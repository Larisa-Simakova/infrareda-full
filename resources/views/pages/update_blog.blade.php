@extends('template.app')
@section('page')
    <section class="admin">
        <div class="container">
            <div class="admin-actions">
                <div class="admin-buttons">
                    <a href="{{ route('view.admin') }}" class="button-transparent">Товары</a>
                    <a href="{{ route('view.admin.objects') }}" class="button-transparent">Объекты</a>
                    <a href="{{ route('view.admin.blogs') }}" class="button-transparent">Блог</a>
                </div>
            </div>
            <form class="form-update" action="{{ route('blog.update', $blog->id) }}" method="POST"
                enctype="multipart/form-data" id="blogForm">
                @csrf
                @method('PUT')
                <h2>Редактирование новости {{ $blog->title }}</h2>
                <div class="form-with-images">
                    <div class="form-inputs">
                        <div class="form-input">
                            <label for="title" class="text-medium">Название <span style="color: red;">*</span></label>
                            <input id="title" type="text" name="title" class="input-white"
                                placeholder="Введите название..." value="{{ old('title', $blog->title) }}">
                            @error('title')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <p class="text-medium">Описание <span style="color: red;">*</span></p>
                            <textarea id="editor" name="description">{{ old('description', $blog->description) }}</textarea>
                            @error('description')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="date" class="text-medium">Дата <span style="color: red;">*</span></label>
                            <input id="date" type="date" placeholder="Введите дату..." name="date"
                                class="input-white"
                                value="{{ old('date', $blog->date ? $blog->date->format('Y-m-d') : '') }}">
                            @error('date')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label class="button-red">
                                Загрузить изображения
                                <input type="file" name="images[]" id="imageUpload" multiple class="visually-hidden">
                            </label>
                            <div id="imageErrors"></div>
                            @error('images')
                                <div id="uploadedImagesError" class="error text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="update-images" id="blogImages">
                            @foreach ($blog->images as $image)
                                <div class="image-block" data-id="{{ $image->id }}">
                                    <img src="{{ secure_asset('storage/' . $image->url) }}" alt="">
                                    <button type="button" class="button-transparent delete-image"
                                        data-id="{{ $image->id }}">
                                        Удалить фото
                                    </button>
                                    <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="button-red">Редактировать</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.addEventListener('click', async function(e) {
                if (!e.target.classList.contains('delete-image') || imageUploadManager.isDeleting)
                    return;

                const button = e.target;
                const imageId = button.dataset.id;
                const tempId = button.dataset.temp;
                const imageBlock = button.closest('.image-block');

                if (!imageBlock) return;

                if (!confirm('Вы уверены, что хотите удалить это изображение?')) {
                    return;
                }

                imageUploadManager.isDeleting = true;

                try {
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                        .content);

                    // Определяем URL и данные для запроса
                    let url;
                    if (imageId) {
                        // Для существующих изображений
                        url = '/blog/image/delete'; // Используем фиксированный маршрут
                        formData.append('id', imageId);
                    } else if (tempId) {
                        // Для временных изображений
                        url = '/blog/image/delete'; // Тот же маршрут, но с temp_id
                        formData.append('temp_id', tempId);
                    } else {
                        throw new Error('Не указан идентификатор изображения');
                    }

                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Ошибка сервера');
                    }

                    const data = await response.json();

                    if (data.success) {
                        imageBlock.remove();
                    } else {
                        throw new Error(data.message || 'Ошибка при удалении');
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    alert('Ошибка при удалении изображения: ' + error.message);
                } finally {
                    imageUploadManager.isDeleting = false;
                }
            });

            initFroalaEditor('#editor', '{{ route('blog.image.description.upload') }}');

            function checkImages() {
                const existingImages = document.querySelectorAll('input[name="existing_images[]"]').length;
                const newImages = document.querySelectorAll('input[name="uploaded_images[]"]').length;
                const hasImages = existingImages + newImages > 0;

                if (!hasImages) {
                    const errorContainer = document.getElementById('imageErrors') || document.createElement('div');
                    errorContainer.innerHTML =
                        '<div class="error text-small">Необходимо оставить или загрузить хотя бы одно изображение</div>';
                    if (!document.getElementById('imageErrors')) {
                        document.querySelector('input[name="images[]"]').parentNode.appendChild(errorContainer);
                    }
                }

                return hasImages;
            }

            setupImageUpload(
                'imageUpload',
                'blogImages',
                '{{ route('blog.image.upload') }}?blog_id={{ $blog->id }}',
                '/blog/image/delete', {
                    imageType: 'blog',
                    onUploadComplete: checkImages
                }
            );

            setupFormValidation('blogForm', [{
                    el: document.querySelector('input[name="title"]'),
                    message: 'Заполните поле'
                },
                {
                    el: document.querySelector('input[name="date"]'),
                    validator: validateDate
                }
            ], {
                editorRequired: true,
                checkImages: checkImages,
                errorMessage: 'Необходимо оставить или загрузить хотя бы одно изображение'
            });
        });
    </script>
@endsection
