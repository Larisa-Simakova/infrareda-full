@extends('pages.add_product_base')
@section('product-content')
    <form class="form-update" action="{{ route('admin.products.advantages.store', $product->id) }}" method="POST"
        id="advantagesForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" value="advantages">

        <h2>Преимущества товара: {{ $product->title }}</h2>

        <div class="form-inputs">
            <div class="form-input">
                <p class="text-medium">Необязательный этап</p>
                <div id="advantages-container">
                    @php
                        $advantages = old('advantages', $product->advantages ?? []);
                        // Всегда показываем хотя бы один блок
                        if (empty($advantages)) {
                            $advantages = [
                                [
                                    'title' => '',
                                    'description' => '',
                                    'traditional_description' => '',
                                    'infrared_description' => '',
                                    'img' => '',
                                ],
                            ];
                        }
                    @endphp

                    @foreach ($advantages as $index => $advantage)
                        <div class="advantage-item item" data-index="{{ $index }}">
                            <div class="form-input">
                                <label class="text-medium" for="advantage-title-{{ $index }}">Заголовок
                                    преимущества <span style="color: red;">*</span></label>
                                <input type="text" id="advantage-title-{{ $index }}"
                                    name="advantages[{{ $index }}][title]" class="input-white"
                                    value="{{ $advantage['title'] ?? '' }}" placeholder="Например: Энергоэффективность">
                            </div>

                            <div class="form-input">
                                <label class="text-medium" for="advantage-description-{{ $index }}">Описание
                                    преимущества <span style="color: red;">*</span></label>
                                <textarea id="editor" name="advantages[{{ $index }}][description]" class="input-white"
                                    placeholder="Подробное описание преимущества">{{ $advantage['description'] ?? '' }}</textarea>
                            </div>

                            <div class="form-input">
                                <label class="text-medium" for="advantage-traditional-{{ $index }}">Описание для
                                    традиционного отопления <span style="color: red;">*</span></label>
                                <textarea id="editor" name="advantages[{{ $index }}][traditional_description]" class="input-white"
                                    placeholder="Описание для традиционного отопления">{{ $advantage['traditional_description'] ?? '' }}</textarea>
                            </div>

                            <div class="form-input">
                                <label class="text-medium" for="advantage-infrared-{{ $index }}">Описание для
                                    инфракрасного отопления <span style="color: red;">*</span></label>
                                <textarea id="editor" name="advantages[{{ $index }}][infrared_description]" class="input-white"
                                    placeholder="Описание для инфракрасного отопления">{{ $advantage['infrared_description'] ?? '' }}</textarea>
                            </div>

                            <div class="form-input image-upload-container">
                                <div class="image-preview-container" id="advantage-image-preview-{{ $index }}">
                                    @if (!empty($advantage['img']))
                                        <div class="image-block">
                                            <img src="{{ secure_asset('storage/' . $advantage['img']) }}" alt="Preview">
                                            <input type="hidden" name="advantages[{{ $index }}][img]"
                                                value="{{ $advantage['img'] }}">
                                        </div>
                                    @endif
                                </div>

                                @if (empty($advantage['img']))
                                    <label class="button-red">
                                        Загрузить иконку
                                        <input type="file" name="advantages[{{ $index }}][image]"
                                            id="advantage-image-upload-{{ $index }}" class="visually-hidden"
                                            accept="image/*">
                                    </label>
                                @else
                                    <label class="button-red">
                                        Заменить иконку
                                        <input type="file" name="advantages[{{ $index }}][image]"
                                            id="advantage-image-replace-{{ $index }}" class="visually-hidden"
                                            accept="image/*">
                                    </label>
                                @endif
                                <div class="error-container"></div>
                            </div>

                            <button type="button" class="button-transparent remove-item">Удалить преимущество</button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-input">
                <button type="button" id="add-advantage" class="button-transparent">+ Добавить преимущество</button>
            </div>
        </div>

        <div class="admin-buttons">
            <button type="submit" class="button-red">Сохранить и продолжить</button>
            <button type="button" class="button-transparent" id="saveAndExitButton">Сохранить и выйти</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initFroalaEditor('#editor', '{{ route('admin.products.images.upload') }}');
            const advantagesContainer = document.getElementById('advantages-container');
            const uploadRoute = '{{ route('admin.products.advantages.images.temp-upload') }}';

            // Инициализация - добавляем один блок, если нет существующих
            if (advantagesContainer.querySelectorAll('.advantage-item').length === 0) {
                addAdvantageField();
            }

            // Функция для обработки загрузки изображения
            function handleImageUpload(input, previewId, index) {
                const container = input?.closest('.image-upload-container');
                if (!container) {
                    console.error('Image upload container not found');
                    return;
                }

                const file = input.files[0];
                if (!file) {
                    const errorContainer = container.querySelector('.error-container');
                    if (errorContainer) errorContainer.textContent = 'Файл не выбран';
                    return;
                }

                const uploadLabel = input.closest('label');
                if (!uploadLabel) {
                    console.error('Upload label not found');
                    return;
                }

                const formData = new FormData();
                formData.append('images[]', file);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('image_type', 'advantage');

                // Показываем индикатор загрузки
                uploadLabel.style.opacity = '0.5';
                uploadLabel.textContent = 'Загрузка...';

                fetch(uploadRoute, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (!data.success || !data.images?.length) {
                            throw new Error(data.message || 'Ошибка при загрузке изображения');
                        }

                        const imageData = data.images[0];
                        const previewContainer = document.getElementById(previewId);
                        if (!previewContainer) {
                            throw new Error('Preview container not found');
                        }

                        previewContainer.innerHTML = `
                        <div class="image-block">
                            <img src="${imageData.url}" alt="Preview">
                            <input type="hidden" name="advantages[${index}][temp_image_id]" value="${imageData.temp_id}">
                            <input type="hidden" name="advantages[${index}][img]" value="${imageData.url}">
                        </div>
                    `;

                        container.classList.add('image-uploaded');

                        // Создаем новую кнопку замены
                        const newLabel = document.createElement('label');
                        newLabel.className = 'button-red';
                        newLabel.innerHTML = `
                        Заменить иконку
                        <input type="file" name="advantages[${index}][image]"
                               id="advantage-image-replace-${index}"
                               class="visually-hidden" accept="image/*">
                    `;

                        if (uploadLabel.parentNode) {
                            uploadLabel.parentNode.replaceChild(newLabel, uploadLabel);
                        }

                        const newInput = newLabel.querySelector('input');
                        if (newInput) {
                            newInput.addEventListener('change', function() {
                                handleImageUpload(this, previewId, index);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error uploading image:', error);
                        const errorContainer = container.querySelector('.error-container');
                        if (errorContainer) errorContainer.textContent = 'Ошибка: ' + error.message;

                        if (uploadLabel) {
                            uploadLabel.style.opacity = '1';
                            uploadLabel.innerHTML = `
                            Загрузить иконку
                            <input type="file" name="advantages[${index}][image]"
                                   id="advantage-image-upload-${index}"
                                   class="visually-hidden" accept="image/*">
                        `;

                            const newInput = uploadLabel.querySelector('input');
                            if (newInput) {
                                newInput.addEventListener('change', function() {
                                    handleImageUpload(this, previewId, index);
                                });
                            }
                        }
                    });
            }

            // Инициализация загрузки изображений для существующих полей
            document.querySelectorAll('.advantage-item').forEach(item => {
                const index = item.dataset.index;
                const uploadInput = document.getElementById(`advantage-image-upload-${index}`);
                const replaceInput = document.getElementById(`advantage-image-replace-${index}`);
                const previewId = `advantage-image-preview-${index}`;

                if (uploadInput) {
                    uploadInput.addEventListener('change', function() {
                        handleImageUpload(this, previewId, index);
                    });
                }

                if (replaceInput) {
                    replaceInput.addEventListener('change', function() {
                        handleImageUpload(this, previewId, index);
                    });
                }
            });

            // Функция для добавления нового поля преимущества
            function addAdvantageField(data = {}) {
                const newIndex = advantagesContainer.querySelectorAll('.advantage-item').length;
                const div = document.createElement('div');
                div.className = 'advantage-item item';
                div.dataset.index = newIndex;

                div.innerHTML = `
                    <div class="form-input">
                        <label class="text-medium" for="advantage-title-${newIndex}">Заголовок преимущества <span style="color: red;">*</span> </label>
                        <input type="text" id="editor" name="advantages[${newIndex}][title]"
                               class="input-white" value="${data.title || ''}"
                               placeholder="Например: Энергоэффективность">
                    </div>

                    <div class="form-input">
                        <label class="text-medium" for="advantage-description-${newIndex}">Описание преимущества <span style="color: red;">*</span> </label>
                        <textarea id="editor" name="advantages[${newIndex}][description]"
                                  class="input-white" placeholder="Подробное описание преимущества">${data.description || ''}</textarea>
                    </div>

                    <div class="form-input">
                        <label class="text-medium" for="advantage-traditional-${newIndex}">Описание для традиционного отопления <span style="color: red;">*</span> </label>
                        <textarea id="editor" name="advantages[${newIndex}][traditional_description]"
                                  class="input-white" placeholder="Описание для традиционного отопления">${data.traditional_description || ''}</textarea>
                    </div>

                    <div class="form-input">
                        <label class="text-medium" for="advantage-infrared-${newIndex}">Описание для инфракрасного отопления <span style="color: red;">*</span> </label>
                        <textarea id="editor" name="advantages[${newIndex}][infrared_description]"
                                  class="input-white" placeholder="Описание для инфракрасного отопления">${data.infrared_description || ''}</textarea>
                    </div>

                    <div class="form-input image-upload-container">
                        <div class="image-preview-container" id="advantage-image-preview-${newIndex}">
                            ${data.img ? `
                                                                                <div class="image-block">
                                                                                    <img src="${data.img}" alt="Preview">
                                                                                    <input type="hidden" name="advantages[${newIndex}][img]" value="${data.img}">
                                                                                </div>
                                                                            ` : ''}
                        </div>

                        <label class="button-red">
                            ${data.img ? 'Заменить иконку' : 'Загрузить иконку'}
                            <input type="file" name="advantages[${newIndex}][image]"
                                   id="advantage-image-${data.img ? 'replace' : 'upload'}-${newIndex}"
                                   class="visually-hidden" accept="image/*">
                        </label>
                        <div class="error-container"></div>
                    </div>

                    <button type="button" class="button-transparent remove-item">Удалить преимущество</button>
                `;

                advantagesContainer.appendChild(div);

                const input = div.querySelector(`#advantage-image-${data.img ? 'replace' : 'upload'}-${newIndex}`);
                if (input) {
                    input.addEventListener('change', function() {
                        handleImageUpload(this, `advantage-image-preview-${newIndex}`, newIndex);
                    });
                }
            }

            // Добавление нового преимущества
            document.getElementById('add-advantage').addEventListener('click', function() {
                addAdvantageField();
            });

            // Удаление преимущества
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    const items = advantagesContainer.querySelectorAll('.advantage-item');

                    if (items.length === 1) {
                        // Если удаляется последнее поле - очищаем его вместо удаления
                        const inputs = items[0].querySelectorAll('input, textarea');
                        inputs.forEach(input => {
                            if (input.type !== 'hidden') {
                                input.value = '';
                            }
                        });

                        // Удаляем иконку
                        const previewContainer = items[0].querySelector('.image-preview-container');
                        previewContainer.innerHTML = '';

                        // Обновляем кнопку загрузки
                        const container = items[0].querySelector('.image-upload-container');
                        const newLabel = document.createElement('label');
                        newLabel.className = 'button-red';
                        newLabel.innerHTML = `
                            Загрузить иконку
                            <input type="file" name="advantages[0][image]"
                                id="advantage-image-upload-0"
                                class="visually-hidden" accept="image/*">
                        `;
                        container.replaceChild(newLabel, container.querySelector('label'));

                        // Назначаем обработчик
                        newLabel.querySelector('input').addEventListener('change', function() {
                            handleImageUpload(this, 'advantage-image-preview-0', 0);
                        });
                    } else {
                        if (confirm('Вы уверены, что хотите удалить это преимущество?')) {
                            e.target.closest('.advantage-item').remove();
                        }
                    }
                }
            });

            // Обработка сохранения и выхода
            document.getElementById('saveAndExitButton').addEventListener('click', function() {
                document.querySelector('input[name="step"]').value = 'complete';
                document.getElementById('advantagesForm').submit();
            });

            // Валидация формы
            setupOptionalFormValidation('advantagesForm', function() {
                const fields = [];
                let hasFilledFields = false;

                document.querySelectorAll('.advantage-item').forEach(item => {
                    const index = item.dataset.index;
                    const title = item.querySelector(`input[name="advantages[${index}][title]"]`);
                    const description = item.querySelector(
                        `textarea[name="advantages[${index}][description]"]`);
                    const traditionalDesc = item.querySelector(
                        `textarea[name="advantages[${index}][traditional_description]"]`);
                    const infraredDesc = item.querySelector(
                        `textarea[name="advantages[${index}][infrared_description]"]`);
                    const imageInput = item.querySelector(
                        `input[type="file"][name="advantages[${index}][image]"]`);
                    const imageHidden = item.querySelector(
                        `input[type="hidden"][name="advantages[${index}][img]"]`);
                    const tempImageId = item.querySelector(
                        `input[type="hidden"][name="advantages[${index}][temp_image_id]"]`);

                    const isFilled = title.value.trim() !== '' ||
                        description.value.trim() !== '' ||
                        traditionalDesc.value.trim() !== '' ||
                        infraredDesc.value.trim() !== '' ||
                        (imageInput && imageInput.files && imageInput.files.length > 0) ||
                        (imageHidden && imageHidden.value !== '') ||
                        (tempImageId && tempImageId.value !== '');

                    if (isFilled) {
                        hasFilledFields = true;

                        if (title.value.trim() === '') {
                            fields.push({
                                el: title,
                                message: 'Заполните поле'
                            });
                        }

                        if (description.value.trim() === '') {
                            fields.push({
                                el: description,
                                message: 'Заполните поле'
                            });
                        }

                        if (traditionalDesc.value.trim() === '') {
                            fields.push({
                                el: traditionalDesc,
                                message: 'Заполните поле'
                            });
                        }

                        if (infraredDesc.value.trim() === '') {
                            fields.push({
                                el: infraredDesc,
                                message: 'Заполните поле'
                            });
                        }

                        if ((!imageInput || !imageInput.files || imageInput.files.length === 0) &&
                            (!imageHidden || imageHidden.value === '') &&
                            (!tempImageId || tempImageId.value === '')) {
                            fields.push({
                                el: imageInput || item.querySelector(
                                    '.image-upload-container'),
                                message: 'Загрузите иконку преимущества',
                                isFile: true
                            });
                        }
                    }
                });

                return hasFilledFields ? fields : [];
            });
        });
    </script>
@endsection
