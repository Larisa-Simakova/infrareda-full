<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogImage;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function showBlogs()
    {
        $blogs = Blog::orderBy('date', 'desc')->paginate(6);
        return view('pages.blogs', compact('blogs'));
    }

    public function showBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blogs = Blog::where('id', '!=', $blog->id)->get();
        return view('pages.blog', compact('blog', 'blogs'));
    }

    public function showCreateBlog()
    {
        return view('pages.add_blog');
    }

    public function uploadDescriptionImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:5120'
        ]);

        $path = $request->file('upload')->store('public/description-images');
        $url = asset(Storage::url($path));

        return response()->json([
            'url' => $url,
            'uploaded' => true
        ]);
    }

    public function createBlog(Request $request)
    {
        $currentYear = date('Y');
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
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
            'uploaded_images' => 'required'
        ], [
            'title.required' => 'Заполните поле',
            'description.required' => 'Заполните поле',
            'date.required' => 'Заполните поле',
            'date.date' => 'Поле должно иметь формат даты',
            'uploaded_images.required' => 'Необходимо загрузить хотя бы одно изображение',
        ]);

        $tempFiles = session()->get('temp_blog_images', []);

        try {
            $blog = Blog::create($data);

            foreach ($request->uploaded_images as $tempId) {
                if (isset($tempFiles[$tempId])) {
                    $oldPath = $tempFiles[$tempId];
                    $newPath = str_replace('temp/', '', $oldPath);

                    Storage::disk('public')->move($oldPath, $newPath);
                    BlogImage::create([
                        'url' => $newPath,
                        'blog_id' => $blog->id
                    ]);
                }
            }

            Storage::disk('public')->deleteDirectory('temp/blogs');
            session()->forget('temp_blog_images');
            return redirect()->route('view.admin.blogs')->with('success', [
                'message' => 'Блог успешно создан',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            foreach ($request->uploaded_images ?? [] as $tempId) {
                if (isset($tempFiles[$tempId])) {
                    $newPath = str_replace('temp/', '', $tempFiles[$tempId]);
                    Storage::disk('public')->delete($newPath);
                }
            }
            return back()->withInput()->withErrors(['error' => 'Ошибка при создании блога: ' . $e->getMessage()]);
        }
    }

    public function showUpdateBlog($id)
    {
        $blog = Blog::findOrFail($id);
        return view('pages.update_blog', compact('blog'));
    }
    public function updateBlog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'exists:blog_images,id',
            'uploaded_images' => 'nullable|array',
        ], [
            'title.required' => 'Заполните поле',
            'description.required' => 'Заполните поле',
            'date.required' => 'Заполните поле',
            'date.date' => 'Поле должно иметь формат даты',
        ]);

        // Проверка изображений перед валидацией
        $hasExistingImages = !empty($request->existing_images);
        $hasNewImages = !empty($request->uploaded_images);

        if (!$hasExistingImages && !$hasNewImages) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['images' => 'Необходимо оставить или загрузить хотя бы одно изображение']);
        }

        // Если валидация прошла, обновляем данные
        $blog->update($data);

        // Обработка существующих изображений
        if (!empty($request->existing_images)) {
            $blog->images()->whereNotIn('id', $request->existing_images)->delete();
        } else {
            $blog->images()->delete();
        }

        // Обработка новых изображений
        if (!empty($request->uploaded_images)) {
            $tempFiles = session()->get('temp_blog_images', []);

            foreach ($request->uploaded_images as $tempId) {
                if (isset($tempFiles[$tempId])) {
                    $oldPath = $tempFiles[$tempId];
                    $newPath = str_replace('temp/', '', $oldPath);

                    Storage::disk('public')->move($oldPath, $newPath);

                    $blog->images()->create([
                        'url' => $newPath
                    ]);
                }
            }

            Storage::disk('public')->deleteDirectory('temp/blogs');
            session()->forget('temp_blog_images');
        }
        return redirect()->route('view.admin.blogs')->with('success', [
            'message' => 'Блог успешно обновлен',
            'type' => 'success'
        ]);
    }
    public function uploadBlogImage(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,svg,webp',
            'blog_id' => 'nullable|exists:blogs,id'
        ]);

        $tempFiles = session()->get('temp_blog_images', []);
        $uploadedImages = [];

        foreach ($request->file('images') as $image) {
            $tempId = uniqid();
            $path = $image->storeAs('temp/blogs', $tempId . '.' . $image->extension(), 'public');

            $tempFiles[$tempId] = $path;

            $uploadedImages[] = [
                'url' => asset('storage/' . $path),
                'temp_id' => $tempId
            ];
        }

        session()->put('temp_blog_images', $tempFiles);

        return response()->json([
            'success' => true,
            'images' => $uploadedImages
        ]);
    }
    public function deleteBlogImage(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:blog_images,id',
            'temp_id' => 'nullable|string'
        ]);

        if ($request->id) {
            // Удаление существующего изображения
            $image = BlogImage::find($request->id);
            Storage::disk('public')->delete($image->url);
            $image->delete();
        } elseif ($request->temp_id) {
            // Удаление временного изображения
            $files = Storage::disk('public')->files('temp/blog_images');
            foreach ($files as $file) {
                if (str_contains($file, $request->temp_id)) {
                    Storage::disk('public')->delete($file);
                    break;
                }
            }
        }

        return response()->json(['success' => true]);
    }
    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            foreach ($blog->images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }
            $blog->delete();
            return response()->json([
                'success' => true,
                'message' => 'Новость успешно удалена'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении новости'
            ], 500);
        }
    }
}
