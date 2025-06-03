<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectImage;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ObjectController extends Controller
{
    public function showObjects(Request $request)
    {
        $products = Product::all();

        $query = Project::orderBy('date', 'desc');

        if ($request->has('product_id') && $request->product_id != 'all') {
            $query->where('product_id', $request->product_id);
        }

        $objects = $query->paginate(9);

        return view('pages.objects', compact('objects', 'products'));
    }

    public function showObject($id)
    {
        $object = Project::findOrFail($id);
        $similarObjects = Project::where('product_id', $object->product_id)
            ->where('id', '!=', $id)
            ->get();
        if ($similarObjects->count() < 4) {
            $additionalProjects = Project::where('product_id', '!=', $object->product_id)
                ->limit(4 - $similarObjects->count())
                ->get();
            $similarObjects = $similarObjects->merge($additionalProjects);
        }
        return view('pages.object', compact('object', 'similarObjects'));
    }

    public function showCreateObject()
    {
        $products = Product::all();
        return view('pages.add_object', compact('products'));
    }

    public function uploadDescriptionImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:5120'
        ]);

        $path = $request->file('upload')->store('public/description-images');
        $url = asset(Storage::url($path));

        return response()->json([
            'url' => $url,
            'uploaded' => true
        ]);
    }

    public function createObject(Request $request)
    {
        $currentYear = date('Y');
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $inputDate = new DateTime($value);
                    $currentDate = new DateTime();
                    $year2000 = new DateTime('2000-01-01');

                    if ($inputDate < $year2000) {
                        $fail("Дата не может быть раньше 2000 года");
                    }

                    if ($inputDate > $currentDate) {
                        $fail("Дата не может быть в будущем");
                    }
                }
            ],
            'place' => 'required|string|max:255',
            'square' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
            'uploaded_images' => 'required'
        ], [
            'title.required' => 'Заполните поле',
            'description.required' => 'Заполните поле',
            'date.required' => 'Заполните поле',
            'date.date' => 'Поле должно иметь формат даты',
            'place.required' => 'Заполните поле',
            'square.required' => 'Заполните поле',
            'square.numeric' => 'Площадь должна быть числом',
            'height.required' => 'Заполните поле',
            'height.numeric' => 'Высота должна быть числом',
            'uploaded_images.required' => 'Необходимо загрузить хотя бы одно изображение',
        ]);

        $tempFiles = session()->get('temp_object_images', []);

        try {
            $object = Project::create($data);

            foreach ($request->uploaded_images as $tempId) {
                if (isset($tempFiles[$tempId])) {
                    $oldPath = $tempFiles[$tempId];
                    $newPath = str_replace('temp/', '', $oldPath);

                    Storage::disk('public')->move($oldPath, $newPath);
                    ProjectImage::create([
                        'url' => $newPath,
                        'project_id' => $object->id
                    ]);
                }
            }

            Storage::disk('public')->deleteDirectory('temp/objects');
            session()->forget('temp_object_images');
            return redirect()->route('view.admin.objects')->with('success', [
                'message' => 'Объект успешно создан',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            foreach ($request->uploaded_images ?? [] as $tempId) {
                if (isset($tempFiles[$tempId])) {
                    $newPath = str_replace('temp/', '', $tempFiles[$tempId]);
                    Storage::disk('public')->delete($newPath);
                }
            }
            return back()->withInput()->withErrors(['error' => 'Ошибка при создании объекта: ' . $e->getMessage()]);
        }
    }

    public function showUpdateObject($id)
    {
        $products = Product::all();
        $object = Project::findOrFail($id);
        return view('pages.update_object', compact('object', 'products'));
    }

    public function updateObject(Request $request, $id)
    {
        $object = Project::findOrFail($id);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'place' => 'required',
            'square' => 'required|numeric',
            'height' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'exists:project_images,id',
            'uploaded_images' => 'nullable|array',
        ], [
            'title.required' => 'Заполните поле',
            'description.required' => 'Заполните поле',
            'date.required' => 'Заполните поле',
            'date.date' => 'Поле должно иметь формат даты',
            'place.required' => 'Заполните поле',
            'square.required' => 'Заполните поле',
            'square.numeric' => 'Площадь должна быть числовым значением',
            'height.required' => 'Заполните поле',
            'height.numeric' => 'Высота должна быть числовым значением',
            'product_id.required' => 'Выберите систему отопления',
        ]);

        $hasExistingImages = !empty($request->existing_images);
        $hasNewImages = !empty($request->uploaded_images);

        if (!$hasExistingImages && !$hasNewImages) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['images' => 'Необходимо оставить или загрузить хотя бы одно изображение']);
        }

        $object->update($data);

        if ($hasExistingImages) {
            $object->images()->whereNotIn('id', $request->existing_images)->delete();
        } else {
            $object->images()->delete();
        }

        if ($hasNewImages) {
            $tempFiles = session()->get('temp_object_images', []);

            foreach ($request->uploaded_images as $tempId) {
                if (isset($tempFiles[$tempId])) {
                    $oldPath = $tempFiles[$tempId];
                    $newPath = str_replace('temp/', '', $oldPath);

                    Storage::disk('public')->move($oldPath, $newPath);

                    $object->images()->create([
                        'url' => $newPath
                    ]);
                }
            }

            Storage::disk('public')->deleteDirectory('temp/objects');
            session()->forget('temp_object_images');
        }

        return redirect()->route('view.admin.objects')->with('success', [
            'message' => 'Объект успешно обновлен',
            'type' => 'success'
        ]);
    }

    public function uploadObjectImage(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,svg,webp|max:5120',
            'object_id' => 'nullable|exists:projects,id'
        ]);

        $tempFiles = session()->get('temp_object_images', []);
        $uploadedImages = [];

        foreach ($request->file('images') as $image) {
            $tempId = uniqid();
            $path = $image->storeAs('temp/objects', $tempId . '.' . $image->extension(), 'public');

            $tempFiles[$tempId] = $path;

            $uploadedImages[] = [
                'url' => asset('storage/' . $path),
                'temp_id' => $tempId
            ];
        }

        session()->put('temp_object_images', $tempFiles);

        return response()->json([
            'success' => true,
            'images' => $uploadedImages
        ]);
    }

    public function deleteObjectImage(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:project_images,id',
            'temp_id' => 'nullable|string'
        ]);

        if ($request->id) {
            $image = ProjectImage::find($request->id);
            Storage::disk('public')->delete($image->url);
            $image->delete();
        } elseif ($request->temp_id) {
            $tempFiles = session()->get('temp_object_images', []);
            if (isset($tempFiles[$request->temp_id])) {
                Storage::disk('public')->delete($tempFiles[$request->temp_id]);
                unset($tempFiles[$request->temp_id]);
                session()->put('temp_object_images', $tempFiles);
            }
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        try {
            $object = Project::findOrFail($id);
            foreach ($object->images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }
            $object->delete();

            return response()->json([
                'success' => true,
                'message' => 'Объект успешно удален'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении объекта'
            ], 500);
        }
    }
}
