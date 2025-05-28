@extends('pages.add_product_base')
@section('product-content')
    <form class="form-update" action="{{ route('admin.products.modifications.finalize', $product->id) }}" method="POST"
        id="modificationsForm">
        @csrf
        <input type="hidden" name="step" value="modifications">

        <h2>Характеристики товара: {{ $product->title }}</h2>

        <div class="form-input">
            <p class="text-medium">Необязательный этап</p>

            <!-- Блок модификаций -->
            <div class="section-block">
                <div id="modifications-container">
                    @foreach ($product->modifications as $modification)
                        <div class="modification-item item" data-id="{{ $modification->id }}">
                            <div class="form-input">
                                <label class="text-medium">Название модификации <span style="color: red;">*</span> </label>
                                <input type="text" class="input-white modification-title"
                                    value="{{ $modification->title }}" placeholder="Введите название модификации...">
                            </div>
                            <div class="admin-buttons">
                                <button type="button" class="button-red save-modification"
                                    data-id="{{ $modification->id }}">Сохранить</button>
                                <button type="button" class="button-transparent remove-modification"
                                    data-id="{{ $modification->id }}">Удалить</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="new-modification-form">
                    <div class="form-input">
                        <label class="text-medium">Новая модификация</label>
                        <input type="text" class="input-white new-modification-title" placeholder="Введите название...">
                    </div>
                    <button type="button" class="button-red" id="save-new-modification">Добавить</button>
                </div>
            </div>

            <!-- Блок характеристик -->
            <div class="section-block">
                <div id="characteristics-container">
                    @php
                        $characteristics = \App\Models\Characteristic::all();
                    @endphp
                    @foreach ($characteristics as $characteristic)
                        <div class="characteristic-item item" data-id="{{ $characteristic->id }}">
                            <div class="form-input">
                                <label class="text-medium">Название характеристики</label>
                                <input type="text" class="input-white characteristic-title"
                                    value="{{ $characteristic->title }}" placeholder="Введите название характеристики...">
                            </div>
                            <div class="admin-buttons">
                                <button type="button" class="button-red save-characteristic"
                                    data-id="{{ $characteristic->id }}">Сохранить</button>
                                <button type="button" class="button-transparent remove-characteristic"
                                    data-id="{{ $characteristic->id }}">Удалить</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="new-characteristic-form">
                    <div class="form-input">
                        <label class="text-medium">Новая характеристика</label>
                        <input type="text" class="input-white new-characteristic-title"
                            placeholder="Введите название...">
                    </div>
                    <button type="button" class="button-red" id="save-new-characteristic">Добавить</button>
                </div>
            </div>

            <!-- Блок значений характеристик -->
            <div class="section-block">
                <div id="values-container">
                    @foreach ($product->modificationCharacteristics as $value)
                        <div class="value-item item" data-id="{{ $value->id }}">
                            <div class="form-inputs">
                                <div class="form-input">
                                    <label class="text-medium">Модификация</label>
                                    <select class="input-white value-modification">
                                        @foreach ($product->modifications as $modification)
                                            <option value="{{ $modification->id }}"
                                                {{ $value->modification_id == $modification->id ? 'selected' : '' }}>
                                                {{ $modification->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-input">
                                    <label class="text-medium">Характеристика</label>
                                    <select class="input-white value-characteristic">
                                        @foreach ($characteristics as $characteristic)
                                            <option value="{{ $characteristic->id }}"
                                                {{ $value->characteristic_id == $characteristic->id ? 'selected' : '' }}>
                                                {{ $characteristic->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-input">
                                    <label class="text-medium">Значение</label>
                                    <input type="text" class="input-white value-value" value="{{ $value->value }}"
                                        placeholder="Введите значение...">
                                </div>
                            </div>
                            <div class="admin-buttons">
                                <button type="button" class="button-red save-value"
                                    data-id="{{ $value->id }}">Сохранить</button>
                                <button type="button" class="button-transparent remove-value"
                                    data-id="{{ $value->id }}">Удалить</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="new-value-form">
                    <div class="form-inputs">
                        <div class="form-input">
                            <label class="text-medium">Модификация</label>
                            <select class="input-white new-value-modification">
                                <option value="">Выберите модификацию</option>
                                @foreach ($product->modifications as $modification)
                                    <option value="{{ $modification->id }}">{{ $modification->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-input">
                            <label class="text-medium">Характеристика</label>
                            <select class="input-white new-value-characteristic">
                                <option value="">Выберите характеристику</option>
                                @foreach ($characteristics as $characteristic)
                                    <option value="{{ $characteristic->id }}">{{ $characteristic->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-input">
                            <label class="text-medium">Значение</label>
                            <input type="text" class="input-white new-value-value" placeholder="Введите значение...">
                        </div>
                    </div>
                    <button type="button" class="button-red" id="save-new-value">Добавить</button>
                </div>
            </div>
        </div>

        <div class="admin-buttons">
            <button type="submit" class="button-red">Сохранить и продолжить</button>
            <button type="button" class="button-transparent" id="saveAndExitButton">Сохранить и выйти</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const {
                showError
            } = window;

            // Функция для проверки уникальности значения
            function isValueUnique(modificationId, characteristicId, valueId = null) {
                const existingValues = document.querySelectorAll('.value-item');
                for (const item of existingValues) {
                    if (item.dataset.id === valueId) continue;

                    const itemModId = item.querySelector('.value-modification').value;
                    const itemCharId = item.querySelector('.value-characteristic').value;

                    if (itemModId === modificationId && itemCharId === characteristicId) {
                        return false;
                    }
                }
                return true;
            }

            // Общая функция для отправки запросов
            async function sendRequest(url, method, data, errorElement = null) {
                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || JSON.stringify(errorData.errors) ||
                            'Ошибка сервера');
                    }

                    return await response.json();
                } catch (error) {
                    console.error('Request failed:', error);
                    showError(errorElement || document.getElementById('modificationsForm'), error.message);
                    return {
                        success: false
                    };
                }
            }

            // Обработчики для значений характеристик
            function setupValueHandlers() {
                // Сохранение нового значения
                document.getElementById('save-new-value')?.addEventListener('click', async function() {
                    const modificationSelect = document.querySelector('.new-value-modification');
                    const characteristicSelect = document.querySelector('.new-value-characteristic');
                    const valueInput = document.querySelector('.new-value-value');

                    // Валидация
                    if (!modificationSelect.value) {
                        return showError(modificationSelect, 'Выберите модификацию');
                    }
                    if (!characteristicSelect.value) {
                        return showError(characteristicSelect, 'Выберите характеристику');
                    }
                    if (!valueInput.value.trim()) {
                        return showError(valueInput, 'Введите значение');
                    }
                    if (!isValueUnique(modificationSelect.value, characteristicSelect.value)) {
                        return showError(valueInput,
                            'Для выбранных модификации и характеристики уже есть значение');
                    }

                    const response = await sendRequest(
                        "{{ route('admin.products.values.store', $product->id) }}",
                        'POST', {
                            modification_id: modificationSelect.value,
                            characteristic_id: characteristicSelect.value,
                            value: valueInput.value.trim()
                        },
                        valueInput
                    );

                    if (response.success) {
                        location.reload();
                    }
                });

                // Сохранение существующего значения
                document.querySelectorAll('.save-value').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        const id = this.dataset.id;
                        const item = document.querySelector(`.value-item[data-id="${id}"]`);
                        const modificationSelect = item.querySelector('.value-modification');
                        const characteristicSelect = item.querySelector(
                            '.value-characteristic');
                        const valueInput = item.querySelector('.value-value');

                        // Валидация
                        if (!modificationSelect.value) {
                            return showError(modificationSelect, 'Выберите модификацию');
                        }
                        if (!characteristicSelect.value) {
                            return showError(characteristicSelect, 'Выберите характеристику');
                        }
                        if (!valueInput.value.trim()) {
                            return showError(valueInput, 'Введите значение');
                        }
                        if (!isValueUnique(modificationSelect.value, characteristicSelect.value,
                                id)) {
                            return showError(valueInput,
                                'Для выбранных модификации и характеристики уже есть значение'
                            );
                        }

                        await sendRequest(
                            `/admin/products/{{ $product->id }}/values/${id}`,
                            'PUT', {
                                modification_id: modificationSelect.value,
                                characteristic_id: characteristicSelect.value,
                                value: valueInput.value.trim()
                            },
                            valueInput
                        );
                    });
                });

                // Удаление значения
                document.querySelectorAll('.remove-value').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        if (!confirm('Вы уверены, что хотите удалить это значение?')) return;

                        const id = this.dataset.id;
                        const response = await sendRequest(
                            `/admin/products/{{ $product->id }}/values/${id}`,
                            'DELETE', {}
                        );

                        if (response.success) {
                            document.querySelector(`.value-item[data-id="${id}"]`)?.remove();
                        }
                    });
                });
            }

            // Add this near setupValueHandlers()
            function setupModificationHandlers() {
                // Save new modification
                document.getElementById('save-new-modification')?.addEventListener('click', async function() {
                    const titleInput = document.querySelector('.new-modification-title');
                    if (!titleInput.value.trim()) {
                        return showError(titleInput, 'Введите название модификации');
                    }

                    const response = await sendRequest(
                        "{{ route('admin.products.modifications.store', $product->id) }}",
                        'POST', {
                            title: titleInput.value.trim()
                        },
                        titleInput
                    );

                    if (response.success) {
                        location.reload();
                    }
                });

                // Save existing modification
                document.querySelectorAll('.save-modification').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        const id = this.dataset.id;
                        const item = document.querySelector(
                            `.modification-item[data-id="${id}"]`);
                        const titleInput = item.querySelector('.modification-title');

                        if (!titleInput.value.trim()) {
                            return showError(titleInput, 'Введите название модификации');
                        }

                        await sendRequest(
                            `/admin/products/{{ $product->id }}/modifications/${id}`,
                            'PUT', {
                                title: titleInput.value.trim()
                            },
                            titleInput
                        );
                    });
                });

                // Remove modification
                document.querySelectorAll('.remove-modification').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        if (!confirm('Вы уверены, что хотите удалить эту модификацию?')) return;

                        const id = this.dataset.id;
                        const response = await sendRequest(
                            `/admin/products/{{ $product->id }}/modifications/${id}`,
                            'DELETE', {}
                        );

                        if (response.success) {
                            document.querySelector(`.modification-item[data-id="${id}"]`)
                                ?.remove();
                        }
                    });
                });
            }

            function setupCharacteristicHandlers() {
                // Save new characteristic
                document.getElementById('save-new-characteristic')?.addEventListener('click', async function() {
                    const titleInput = document.querySelector('.new-characteristic-title');
                    if (!titleInput.value.trim()) {
                        return showError(titleInput, 'Введите название характеристики');
                    }

                    const response = await sendRequest(
                        "{{ route('admin.products.characteristics.store') }}",
                        'POST', {
                            title: titleInput.value.trim()
                        },
                        titleInput
                    );

                    if (response.success) {
                        location.reload();
                    }
                });

                // Save existing characteristic
                document.querySelectorAll('.save-characteristic').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        const id = this.dataset.id;
                        const item = document.querySelector(
                            `.characteristic-item[data-id="${id}"]`);
                        const titleInput = item.querySelector('.characteristic-title');

                        if (!titleInput.value.trim()) {
                            return showError(titleInput, 'Введите название характеристики');
                        }

                        await sendRequest(
                            `/admin/products/characteristics/${id}`,
                            'PUT', {
                                title: titleInput.value.trim()
                            },
                            titleInput
                        );
                    });
                });

                // Remove characteristic
                document.querySelectorAll('.remove-characteristic').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        if (!confirm('Вы уверены, что хотите удалить эту характеристику?'))
                            return;

                        const id = this.dataset.id;
                        const response = await sendRequest(
                            `/admin/products/characteristics/${id}`,
                            'DELETE', {}
                        );

                        if (response.success) {
                            document.querySelector(`.characteristic-item[data-id="${id}"]`)
                                ?.remove();
                        }
                    });
                });
            }

            setupModificationHandlers();
            setupCharacteristicHandlers();
            setupValueHandlers();

            document.getElementById('saveAndExitButton')?.addEventListener('click', function() {
                document.querySelector('input[name="step"]').value = 'complete';
                document.getElementById('modificationsForm').submit();
            });

            // Отключаем стандартную валидацию для необязательного этапа
            document.getElementById('modificationsForm').addEventListener('submit', function(e) {
                // Никакой валидации, просто отправляем форму
            });
        });
    </script>
@endsection
