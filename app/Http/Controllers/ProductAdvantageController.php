<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Advantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProductAdvantageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Валидация только если есть заполненные преимущества
        $hasAdvantages = false;
        $advantagesData = $request->input('advantages', []);

        foreach ($advantagesData as $advantage) {
            if (!empty($advantage['title'])) {
                $hasAdvantages = true;
                break;
            }
        }

        if ($hasAdvantages) {
            $request->validate([
                'advantages' => 'required|array',
                'advantages.*.title' => 'required|string|max:255',
                'advantages.*.description' => 'required|string',
                'advantages.*.traditional_description' => 'required|string',
                'advantages.*.infrared_description' => 'required|string',
                'advantages.*.image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'advantages.*.img' => 'sometimes|string'
            ]);
        }

        try {
            $product->advantages()->delete();

            if ($hasAdvantages) {
                foreach ($request->input('advantages', []) as $index => $advantage) {
                    if (empty($advantage['title']))
                        continue;

                    // В методе store ProductAdvantageController:
                    $imagePath = null;

                    // Проверяем временное изображение
                    if (!empty($advantage['temp_image_id'])) {
                        $sessionKey = 'temp_advantage_images';
                        $tempFiles = session()->get($sessionKey, []);

                        if (isset($tempFiles[$advantage['temp_image_id']])) {
                            $tempPath = $tempFiles[$advantage['temp_image_id']];
                            $newPath = str_replace('temp/advantage/', 'advantages/', $tempPath);
                            Storage::disk('public')->move($tempPath, $newPath);
                            $imagePath = $newPath;
                            unset($tempFiles[$advantage['temp_image_id']]);
                            session()->put($sessionKey, $tempFiles);
                        }
                    }
                    // Проверяем обычную загрузку
                    elseif ($request->hasFile("advantages.$index.image")) {
                        $imagePath = $request->file("advantages.$index.image")->store('advantages', 'public');
                    }
                    // Проверяем существующее изображение
                    elseif (!empty($advantage['img'])) {
                        $imagePath = str_replace(asset('storage/'), '', $advantage['img']);
                    }

                    Advantage::create([
                        'title' => $advantage['title'],
                        'description' => $advantage['description'],
                        'traditional_description' => $advantage['traditional_description'],
                        'infrared_description' => $advantage['infrared_description'],
                        'img' => $imagePath,
                        'product_id' => $product->id,
                        'order' => $advantage['order'] ?? $index,
                    ]);
                }
            }

            if ($request->input('step') === 'complete') {
                return redirect()->route('view.admin')->with('success', [
                    'message' => 'Изменения успешно сохранены',
                    'type' => 'success'
                ]);
            }

            return redirect()->route('admin.products.edit', [
                'product' => $product->id,
                'step' => 'characteristics'
            ])->with('success', [
                        'message' => 'Изменения успешно сохранены',
                        'type' => 'success'
                    ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ошибка при сохранении: ' . $e->getMessage());
        }
    }

    public function updateOrder(Product $product, Request $request)
    {

        $request->validate([
            'order' => 'required|array',
            'order.*.id' => [
                'required',
            ],
            'order.*.position' => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($product, $request) {
                foreach ($request->order as $item) {
                    $product->advantages()
                        ->where('id', $item['id'])
                        ->update(['order' => $item['position']]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Порядок успешно обновлён'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка сервера: ' . $e->getMessage()
            ], 500);
        }
    }
}
