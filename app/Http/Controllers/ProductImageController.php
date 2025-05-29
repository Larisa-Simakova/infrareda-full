<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function tempUploadImage(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,svg,jpg,webp|max:5120',
            'image_type' => 'sometimes|in:product,advantage,certificate,object,blog'
        ], [
            'images.required' => 'Необходимо загрузить хотя бы одно изображение',
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.mimes' => 'Допустимые форматы: JPEG, PNG, JPG, WEBP, SVG',
            'images.*.max' => 'Максимальный размер файла: 5MB',
        ]);

        $imageType = $request->image_type ?? 'product';
        $sessionKey = 'temp_' . $imageType . '_images';
        $tempFiles = session()->get($sessionKey, []);
        $uploadedImages = [];

        foreach ($request->file('images') as $image) {
            $tempId = Str::uuid()->toString();
            $path = $image->store("temp/{$imageType}", 'public');

            $tempFiles[$tempId] = $path;
            $uploadedImages[] = [
                'temp_id' => $tempId,
                'url' => secure_asset('storage/' . $path)
            ];
        }

        session()->put($sessionKey, $tempFiles);

        return response()->json([
            'success' => true,
            'images' => $uploadedImages
        ]);
    }

    public function tempDeleteImage(Request $request)
    {
        $validated = $request->validate([
            'temp_id' => 'required|string',
            'image_type' => 'sometimes|in:product,advantage,certificate,object,blog'
        ]);

        $imageType = $request->image_type ?? 'product';
        $sessionKey = 'temp_' . $imageType . '_images';
        $tempFiles = session()->get($sessionKey, []);

        if (isset($tempFiles[$request->temp_id])) {
            Storage::disk('public')->delete($tempFiles[$request->temp_id]);
            unset($tempFiles[$request->temp_id]);
            session()->put($sessionKey, $tempFiles);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, ProductImage $image)
    {
        try {
            // Удаляем файл изображения
            $path = str_replace('storage/', '', $image->url);
            Storage::disk('public')->delete($path);

            // Удаляем запись из базы данных
            $image->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
