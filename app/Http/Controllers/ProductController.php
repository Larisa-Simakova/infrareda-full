<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Characteristic;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function showCatalog()
    {
        $products = Product::all();
        return view('pages.catalog', compact('products'));
    }

    public function showProduct($id)
    {
        $product = Product::with([
            'modifications.characteristics',
            'modifications.modificationCharacteristics'
        ])->findOrFail($id);
        $objects = Project::where('product_id', $product->id)->get();
        $latestBlog = Blog::orderBy('date', 'desc')->first();
        $recentBlogs = Blog::where('id', '!=', $latestBlog->id)
            ->orderBy('date', 'desc')
            ->limit(6)
            ->get();
        return view('pages.product', compact('product', 'latestBlog', 'recentBlogs', 'objects'));
    }

    public function create()
    {
        return view('pages.add_product_description', [
            'currentStep' => 'description',
            'product' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string',
            'uploaded_images' => 'required|array|min:1',
        ], [
            'title.required' => 'Заполните название товара',
            'description.required' => 'Заполните описание товара',
            'short_description.required' => 'Заполните короткое описание товара',
            'uploaded_images.required' => 'Необходимо загрузить хотя бы одно изображение',
            'uploaded_images.min' => 'Необходимо загрузить хотя бы одно изображение',
        ]);

        try {
            $product = Product::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'short_description' => $validated['short_description'],
            ]);

            // Обработка изображений
            if ($request->has('uploaded_images')) {
                $this->processImages($product, $request->input('uploaded_images'));
            }

            if ($request->input('step') === 'complete') {
                return redirect()->route('view.admin')->with('success', [
                    'message' => 'Товар успешно создан',
                    'type' => 'success'
                ]);
            }

            return redirect()->route('admin.products.edit', [
                'product' => $product->id,
                'step' => 'usage'
            ])->with('success', [
                        'message' => 'Товар успешно создан',
                        'type' => 'success'
                    ]);

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ошибка при создании товара: ' . $e->getMessage());
        }
    }

    public function edit(Product $product, $step = 'description')
    {
        if (!$product) {
            abort(404);
        }

        $viewTemplate = 'pages.add_product_' . $step;

        if (!view()->exists($viewTemplate)) {
            $viewTemplate = 'pages.add_product_base';
        }

        return view($viewTemplate, [
            'currentStep' => $step,
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string',
            'uploaded_images' => 'required|array|min:1',
        ]);

        try {
            $product->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'short_description' => $validated['short_description'],
            ]);

            // Обработка изображений
            $this->processImages($product, $request->input('uploaded_images'));

            return $request->input('step') === 'complete'
                ? redirect()->route('view.admin')->with('success', [
                    'message' => 'Товар успешно обновлен',
                    'type' => 'success'
                ])
                : redirect()->route('admin.products.edit', [
                    'product' => $product->id,
                    'step' => 'usage'
                ])->with('success', [
                            'message' => 'Товар успешно обновлен',
                            'type' => 'success'
                        ]);


        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ошибка при обновлении товара: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Удаляем изображения
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }

            foreach ($product->certificates as $certificate) {
                Storage::disk('public')->delete($certificate->url);
            }

            foreach ($product->advantages as $advantage) {
                if ($advantage->img) {
                    Storage::disk('public')->delete($advantage->img);
                }
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Товар успешно удален'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении товара: ' . $e->getMessage()
            ], 500);
        }
    }

    private function processImages(Product $product, array $uploadedImages)
    {
        try {
            $tempFiles = session()->get('temp_product_images', []);
            $existingImageIds = $product->images->pluck('id')->toArray();

            // Удаление изображений
            $imagesToDelete = array_diff($existingImageIds, $uploadedImages);
            ProductImage::whereIn('id', $imagesToDelete)->get()->each(function ($image) {
                if (Storage::disk('public')->exists($image->url)) {
                    Storage::disk('public')->delete($image->url);
                }
                $image->delete();
            });

            // Добавление новых изображений
            foreach (array_diff($uploadedImages, $existingImageIds) as $tempId) {
                if (isset($tempFiles[$tempId])) {
                    $this->moveTempImageToPermanent($product, $tempFiles[$tempId]);
                }
            }

            // Очистка временных файлов
            Storage::disk('public')->deleteDirectory('temp/product');
            session()->forget('temp_product_images');

        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function moveTempImageToPermanent(Product $product, $tempPath)
    {
        $newPath = 'products/' . $product->id . '/' . basename($tempPath);

        Storage::disk('public')->makeDirectory('products/' . $product->id);
        Storage::disk('public')->move($tempPath, $newPath);

        return ProductImage::create([
            'product_id' => $product->id,
            'url' => $newPath
        ]);
    }

    public function uploadDescriptionImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:5120' // Froala может использовать 'file' вместо 'upload'
        ]);

        try {
            $path = $request->file('file')->store('public/description-images');

            return response()->json([
                'link' => Storage::url($path),
                'url' => Storage::url($path),
                'uploaded' => true,
                'filePath' => $path
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'uploaded' => false
            ], 500);
        }
    }
}
