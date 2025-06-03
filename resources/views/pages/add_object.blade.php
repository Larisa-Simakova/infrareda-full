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
            <form class="form-update" action="{{ route('object.create') }}" method="POST" enctype="multipart/form-data"
                id="objectForm">
                @csrf
                <h2>Добавление объекта</h2>
                <div class="form-with-images">
                    <div class="form-inputs">
                        <div class="form-input">
                            <label for="title" class="text-medium">Название <span style="color: red;">*</span></label>
                            <input id="title" type="text" name="title" class="input-white"
                                placeholder="Введите название..." value="{{ old('title') }}">
                            @error('title')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label class="text-medium">Описание <span style="color: red;">*</span></label>
                            <textarea id="editor" style="input-white" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="date" class="text-medium">Дата <span style="color: red;">*</span></label>
                            <input id="date" type="date" name="date" class="input-white"
                                placeholder="Введите дату" value="{{ old('date') }}">
                            @error('date')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="place" class="text-medium">Месторасположение <span
                                    style="color: red;">*</span></label>
                            <input id="place" type="text" name="place" class="input-white"
                                placeholder="Введите месторасположение..." value="{{ old('place') }}">
                            @error('place')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="square" class="text-medium">Площадь <span style="color: red;">*</span></label>
                            <input id="square" type="text" name="square" class="input-white"
                                placeholder="Введите площадь..." value="{{ old('square') }}">
                            @error('square')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label for="height" class="text-medium">Высота <span style="color: red;">*</span></label>
                            <input id="height" type="text" name="height" class="input-white"
                                placeholder="Введите высоту..." value="{{ old('height') }}">
                            @error('height')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <p class="text-medium">Система отопления <span style="color: red;">*</span></p>
                            @if ($products->isNotEmpty())
                                <select name="product_id" class="js-choice">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->title }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <p class="text-medium">Нет систем отопления</p>
                            @endif
                            @error('product_id')
                                <p class="error text-small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-input">
                            <label class="button-red">
                                Загрузить изображения
                                <input type="file" name="images[]" id="objectImageUpload" multiple
                                    class="visually-hidden">
                            </label>
                            <div id="imageErrors"></div>
                            @error('uploaded_images')
                                <div id="uploadedImagesError" class="error text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-input">
                            <div id="objectImages" class="update-images">
                            </div>
                        </div>
                        <button type="submit" class="button-red">Добавить</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.addEventListener('click', async function(e) {
                if (e.target.classList.contains('delete-image') && !imageUploadManager
                    .isDeleting) {
                    imageUploadManager.isDeleting = true;

                    const button = e.target;
                    const imageId = button.dataset.id;
                    const tempId = button.dataset.temp;
                    const containerId = button.dataset.container;
                    const imageType = button.dataset.type;
                    const deleteRoute = button.dataset.deleteRoute;
                    const imageBlock = button.closest('.image-block');

                    if (!confirm('Вы уверены, что хотите удалить это изображение?')) {
                        imageUploadManager.isDeleting = false;
                        return;
                    }

                    try {
                        let response;

                        if (tempId) {
                            // Удаление временного изображения (POST)
                            response = await fetch(deleteRoute, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    temp_id: tempId,
                                    image_type: imageType
                                })
                            });
                        } else {
                            // Удаление постоянного изображения (DELETE)
                            response = await fetch(deleteRoute, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content
                                }
                            });
                        }

                        const data = await response.json();

                        if (!response.ok) throw new Error(data.message ||
                            'Ошибка при удалении');

                        if (data.success) {
                            imageBlock.remove();
                        }
                    } catch (error) {
                        console.error('Delete error:', error);
                        alert('Ошибка при удалении изображения: ' + error.message);
                    } finally {
                        imageUploadManager.isDeleting = false;
                    }
                }
            });

            initFroalaEditor('#editor');

            setupImageUpload('objectImageUpload', 'objectImages',
                '{{ route('object.image.upload') }}',
                '{{ route('object.image.delete') }}', {
                    imageType: 'object',
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
                checkImages: true,
                errorMessage: 'Необходимо загрузить хотя бы одно изображение'
            });
        });
    </script>
@endsection
