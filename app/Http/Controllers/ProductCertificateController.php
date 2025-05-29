<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCertificateController extends Controller
{
    public function tempUploadCertificate(Request $request)
    {
        $validated = $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|mimes:pdf|max:10240', // 10MB max для PDF
            'file_type' => 'sometimes|in:certificate' // Можно расширить при необходимости
        ], [
            'files.required' => 'Необходимо загрузить хотя бы один файл',
            'files.*.mimes' => 'Допустимый формат: PDF',
            'files.*.max' => 'Максимальный размер файла: 10MB',
        ]);

        $fileType = $request->file_type ?? 'certificate';
        $sessionKey = 'temp_' . $fileType . '_files';
        $tempFiles = session()->get($sessionKey, []);
        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $tempId = Str::uuid()->toString();
            $path = $file->store("temp/{$fileType}", 'public');

            $tempFiles[$tempId] = $path;
            $uploadedFiles[] = [
                'temp_id' => $tempId,
                'name' => $file->getClientOriginalName(),
                'url' => secure_asset('storage/' . $path),
                'size' => $file->getSize()
            ];
        }

        session()->put($sessionKey, $tempFiles);

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles
        ]);
    }

    public function tempDeleteCertificate(Request $request)
    {
        $validated = $request->validate([
            'temp_id' => 'required|string',
            'file_type' => 'sometimes|in:certificate'
        ]);

        $fileType = $request->file_type ?? 'certificate';
        $sessionKey = 'temp_' . $fileType . '_files';
        $tempFiles = session()->get($sessionKey, []);

        if (isset($tempFiles[$request->temp_id])) {
            Storage::disk('public')->delete($tempFiles[$request->temp_id]);
            unset($tempFiles[$request->temp_id]);
            session()->put($sessionKey, $tempFiles);
        }

        return response()->json(['success' => true]);
    }

    public function store(Request $request, Product $product)
    {
        try {
            $fileType = 'certificate';
            $sessionKey = 'temp_' . $fileType . '_files';
            $tempFiles = session()->get($sessionKey, []);
            $existingCertificates = $product->certificates()->pluck('id')->toArray();
            $newFiles = $request->input('uploaded_files', []);

            // Удаляем сертификаты, которых нет в новом списке
            $toDelete = array_diff($existingCertificates, $newFiles);
            foreach ($toDelete as $id) {
                $certificate = Certificate::find($id);
                if ($certificate) {
                    Storage::disk('public')->delete($certificate->url);
                    $certificate->delete();
                }
            }

            // Обрабатываем новые файлы
            foreach ($newFiles as $fileData) {
                if (Str::isUuid($fileData) && isset($tempFiles[$fileData])) {
                    $this->processCertificateFile($product, $fileData, $tempFiles);
                }
            }

            // Очищаем временные файлы
            Storage::disk('public')->deleteDirectory('temp/certificate');
            session()->forget($sessionKey);

            return $request->input('step') === 'complete'
                ? redirect()->route('view.admin')->with('success', [
                    'message' => 'Изменения успешно сохранены',
                    'type' => 'success'
                ])
                : redirect()->route('admin.products.edit', [
                    'product' => $product->id,
                    'step' => 'faq'
                ])->with('success', [
                            'message' => 'Изменения успешно сохранены',
                            'type' => 'success'
                        ]);

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ошибка сохранения сертификатов: ' . $e->getMessage());
        }
    }

    private function processCertificateFile(Product $product, $tempId, $tempFiles)
    {
        if (isset($tempFiles[$tempId])) {
            $oldPath = $tempFiles[$tempId];
            $extension = pathinfo($oldPath, PATHINFO_EXTENSION);
            $newPath = 'products/' . $product->id . '/certificates/' . Str::random(40) . '.' . $extension;

            Storage::disk('public')->makeDirectory('products/' . $product->id . '/certificates');
            Storage::disk('public')->move($oldPath, $newPath);

            Certificate::create([
                'product_id' => $product->id,
                'url' => $newPath
            ]);
        }
    }

    public function destroy(Product $product, Certificate $certificate)
    {
        try {
            // Проверка принадлежности сертификата к товару
            if ($certificate->product_id != $product->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Сертификат не принадлежит указанному товару'
                ], 403);
            }

            // Удаляем файл
            if (Storage::disk('public')->exists($certificate->url)) {
                Storage::disk('public')->delete($certificate->url);
            }

            // Удаляем запись из базы данных
            $certificate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Сертификат успешно удален'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
