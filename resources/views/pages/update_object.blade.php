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
            <form class="form-update" action="{{ route('object.update', $object->id) }}" method="POST"
                enctype="multipart/form-data" id="objectForm">
                @csrf
                @method('PUT')
                <h2>Редактирование объекта {{ $object->title }}</h2>
                <div class="form-with-images">
                    <div class="form-inputs">
                        <div class="form-input">
                            <label for="title" class="text-medium">Название <span style="color: red;">*</span></label>
                            <input id="title" type="text" name="title" class="input-white"
                                placeholder="Введите название..." value="{{ old('title', $object->title) }}">
                            @error('title')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label class="text-medium">Описание <span style="color: red;">*</span></label>
                            <textarea id="editor" name="description">{{ old('description', $object->description) }}</textarea>
                            @error('description')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="date" class="text-medium">Дата <span style="color: red;">*</span></label>
                            <input id="date" type="date" name="date" placeholder="Введите дату"
                                class="input-white"
                                value="{{ old('date', $object->date ? $object->date->format('Y-m-d') : '') }}">
                            @error('date')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="place" class="text-medium">Месторасположение <span
                                    style="color: red;">*</span></label>
                            <input id="place" type="text" name="place" class="input-white"
                                placeholder="Введите месторасположение..." value="{{ old('place', $object->place) }}">
                            @error('place')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="square" class="text-medium">Площадь <span style="color: red;">*</span></label>
                            <input id="square" type="text" name="square" class="input-white"
                                placeholder="Введите площадь..." value="{{ old('square', $object->square) }}">
                            @error('square')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="height" class="text-medium">Высота <span style="color: red;">*</span></label>
                            <input id="height" type="text" name="height" class="input-white"
                                placeholder="Введите высоту..." value="{{ old('height', $object->height) }}">
                            @error('height')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <p class="text-medium">Система отопления <span style="color: red;">*</span></p>
                            <select name="product_id" class="js-choice">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ $object->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
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
                        <div class="update-images" id="objectImages">
                            @foreach ($object->images as $image)
                                <div class="image-block" data-id="{{ $image->id }}">
                                    <img src="{{ secure_asset('storage/' . $image->url) }}" alt="">
                                    <button type="button" class="button-transparent delete-image"
                                        data-id="{{ $image->id }}"
                                        data-delete-route="{{ route('object.image.delete') }}">
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
                    const response = await fetch('{{ route('object.image.delete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            id: imageId,
                            temp_id: tempId
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) throw new Error(data.message || 'Ошибка при удалении');

                    if (data.success) {
                        imageBlock.remove();
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    alert('Ошибка при удалении изображения: ' + error.message);
                } finally {
                    imageUploadManager.isDeleting = false;
                }
            });

            initFroalaEditor('#editor', '{{ route('object.image.description.upload') }}');

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
                'objectImages',
                '{{ route('object.image.upload') }}?object_id={{ $object->id }}',
                '{{ route('object.image.delete') }}', {
                    imageType: 'object',
                    onUploadComplete: checkImages
                }
            );

            setupFormValidation('objectForm', [{
                    el: document.querySelector('input[name="title"]'),
                    message: 'Заполните поле'
                },
                {
                    el: document.querySelector('input[name="date"]'),
                    validator: validateDate
                },
                {
                    el: document.querySelector('input[name="place"]'),
                    message: 'Заполните поле'
                },
                {
                    el: document.querySelector('input[name="square"]'),
                    validator: (input) => {
                        if (!input.value.trim()) return 'Заполните поле';
                        return validateNumber(input, 'Поле должно быть числовым значением');
                    }
                },
                {
                    el: document.querySelector('input[name="height"]'),
                    validator: (input) => {
                        if (!input.value.trim()) return 'Заполните поле';
                        return validateNumber(input, 'Поле должно быть числовым значением');
                    }
                }
            ], {
                editorRequired: true,
                checkImages: checkImages,
                errorMessage: 'Необходимо оставить или загрузить хотя бы одно изображение'
            });
        });
    </script>
@endsection
