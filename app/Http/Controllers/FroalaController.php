<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FroalaController extends Controller
{
    // Путь для хранения изображений
    protected $imagePath = 'public/froala-images/';

    // Загрузка нового изображения
    public function upload(Request $request)
    {
        try {
            // Валидация
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
            ]);

            // Путь для сохранения (год/месяц/день)
            $path = 'public/froala-images/' . date('Y/m/d');

            // Загрузка файла
            $uploadedPath = $request->file('file')->store($path);

            // Возвращаем ссылку на изображение
            return response()->json([
                'link' => Storage::url($uploadedPath),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    // Загрузка списка изображений
    public function load(Request $request)
    {
        $images = [];
        $files = Storage::files($this->imagePath);

        foreach ($files as $file) {
            if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
                $images[] = [
                    'url' => Storage::url($file),
                    'thumb' => Storage::url($file),
                    'name' => basename($file)
                ];
            }
        }

        return response()->json($images);
    }

    // Удаление изображения
    public function delete(Request $request)
    {
        $request->validate([
            'src' => 'required|string'
        ]);

        $path = str_replace(secure_asset(''), '', $request->src);
        $fullPath = str_replace('storage/', 'public/', $path);

        if (Storage::exists($fullPath)) {
            Storage::delete($fullPath);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
