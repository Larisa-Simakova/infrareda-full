<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\PdfToImage\Pdf;


class ProductCertificateController extends Controller
{

    public function tempUploadCertificate(Request $request)
    {
        $validated = $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|mimes:pdf,png,jpeg,jpg,svg,png,webp|max:10240',
            'file_type' => 'sometimes|in:certificate'
        ]);

        $fileType = $request->file_type ?? 'certificate';
        $sessionKey = 'temp_' . $fileType . '_files';
        $tempFiles = session()->get($sessionKey, []);
        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $tempId = Str::uuid()->toString();
            $originalName = $file->getClientOriginalName();

            // Сохраняем с оригинальным именем во временной папке
            $path = $file->storeAs("temp/{$fileType}", $originalName, 'public');

            $previewUrl = null;
            $extension = strtolower($file->getClientOriginalExtension());

            // Если это PDF - создаем превью
            if ($extension === 'pdf') {
                try {
                    $pdf = new Pdf(storage_path('app/public/' . $path));
                    $previewPath = "temp/{$fileType}/preview_" . pathinfo($originalName, PATHINFO_FILENAME) . '.jpg';
                    $pdf->setPage(1)->saveImage(storage_path('app/public/' . $previewPath));
                    $previewUrl = asset('storage/' . $previewPath);
                } catch (\Exception $e) {
                    $previewUrl = null;
                }
            } else {
                $previewUrl = asset('storage/' . $path);
            }

            $tempFiles[$tempId] = [
                'path' => $path,
                'preview' => $previewUrl,
                'original_name' => $originalName
            ];

            $uploadedFiles[] = [
                'temp_id' => $tempId,
                'name' => $originalName,
                'url' => asset('storage/' . $path),
                'preview_url' => $previewUrl,
                'is_pdf' => $extension === 'pdf',
                'size' => $file->getSize()
            ];
        }

        session()->put($sessionKey, $tempFiles);

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles
        ]);
    }

    private function processCertificateFile(Product $product, $tempId, $tempFiles)
    {
        if (isset($tempFiles[$tempId])) {
            $oldPath = $tempFiles[$tempId]['path'];
            $originalName = $tempFiles[$tempId]['original_name'];

            // Формируем конечный путь с оригинальным именем
            $newPath = 'products/' . $product->id . '/certificates/' . $originalName;

            // Проверяем существование файла и добавляем суффикс при необходимости
            $counter = 1;
            while (Storage::disk('public')->exists($newPath)) {
                $info = pathinfo($originalName);
                $newPath = 'products/' . $product->id . '/certificates/' .
                    $info['filename'] . '_' . $counter . '.' . $info['extension'];
                $counter++;
            }

            Storage::disk('public')->makeDirectory('products/' . $product->id . '/certificates');
            Storage::disk('public')->move($oldPath, $newPath);

            // Если это PDF - создаем превью
            $extension = strtolower(pathinfo($newPath, PATHINFO_EXTENSION));
            if ($extension === 'pdf') {
                try {
                    $pdf = new Pdf(storage_path('app/public/' . $newPath));
                    $previewPath = 'products/' . $product->id . '/certificates/' .
                        pathinfo($newPath, PATHINFO_FILENAME) . '_preview.jpg';
                    $pdf->setPage(1)->saveImage(storage_path('app/public/' . $previewPath));
                } catch (\Exception $e) {
                    Log::error('Failed to create PDF preview: ' . $e->getMessage());
                }
            }

            Certificate::create([
                'product_id' => $product->id,
                'url' => $newPath // Сохраняем путь с оригинальным именем
            ]);
        }
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
