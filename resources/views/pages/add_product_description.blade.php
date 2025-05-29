@extends('pages.add_product_base')
@section('product-content')
    <form class="form-update"
        action="{{ $product ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST"
        enctype="multipart/form-data" id="productForm">
        @csrf
        @if ($product)
            @method('PUT')
        @endif
        <input type="hidden" name="step" value="description">

        <h2>{{ $product ? 'Редактирование товара' : 'Добавление товара' }}</h2>
        <div class="form-inputs">
            <div class="form-input">
                <label for="title" class="text-medium">Название товара <span style="color: red;">*</span></label>
                <input id="title" type="text" placeholder="Введите название..." name="title" class="input-white"
                    value="{{ old('title', $product->title ?? '') }}">
                <div id="titleErrors" class="error-container"></div>
            </div>

            <div class="form-input">
                <p class="text-medium">Короткое описание товара <span style="color: red;">*</span></p>
                <textarea id="short-editor" name="short_description">{{ old('short_description', $product->short_description ?? '') }}</textarea>
            </div>

            <div class="form-input">
                <p class="text-medium">Описание товара <span style="color: red;">*</span></p>
                <textarea id="editor" name="description">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div class="form-input">
                <label class="button-red">
                    Загрузить изображения
                    <input type="file" name="images[]" id="imageUpload" multiple class="visually-hidden">
                </label>
                <div id="imageErrors" class="error-container"></div>
            </div>
            <div id="productImages" class="update-images">
                @if ($product && $product->images)
                    @foreach ($product->images as $image)
                        <div class="image-block" data-id="{{ $image->id }}">
                            <img src="{{ secure_asset('storage/' . str_replace('public/', '', $image->url)) }}"
                                alt="Изображение товара">
                            <button type="button" class="button-transparent delete-image" data-id="{{ $image->id }}"
                                data-container="productImages"
                                data-delete-route="{{ route('admin.products.images.destroy', $image->id) }}">
                                Удалить фото
                            </button>
                            <input type="hidden" name="uploaded_images[]" value="{{ $image->id }}">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="admin-buttons">
            <button type="submit" class="button-red">Сохранить и продолжить</button>
            <button type="button" class="button-transparent" id="saveAndExitButton">Сохранить и выйти</button>
        </div>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Инициализация редактора
            initFroalaEditor('#short-editor', '{{ route('admin.products.images.upload') }}');
            initFroalaEditor('#editor', '{{ route('admin.products.images.upload') }}');

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
                        url = '/admin/products/image/delete'; // Используем фиксированный маршрут
                        formData.append('id', imageId);
                    } else if (tempId) {
                        // Для временных изображений
                        url = '/admin/products/images/temp-delete'; // Тот же маршрут, но с temp_id
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

            // Загрузка изображений
            setupImageUpload('imageUpload', 'productImages',
                '{{ route('admin.products.images.temp-upload') }}',
                '{{ route('admin.products.images.temp-delete') }}', {
                    imageType: 'product',
                    customValidation: true,
                    errorMessage: 'Необходимо загрузить хотя бы одно изображение товара'
                }
            );

            // Обработка сохранения
            document.getElementById('saveAndExitButton').addEventListener('click', function() {
                document.querySelector('input[name="step"]').value = 'complete';
                document.getElementById('productForm').submit();
            });

            // Валидация формы
            setupFormValidation('productForm', [{
                el: document.querySelector('input[name="title"]'),
                message: 'Заполните поле'
            }], {
                editorRequired: true,
                checkImages: function() {
                    return document.querySelectorAll('#productImages .image-block').length > 0;
                },
                errorMessage: 'Необходимо загрузить хотя бы одно изображение товара'
            });
        });
    </script>
@endsection
