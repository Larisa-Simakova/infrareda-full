@extends('pages.add_product_base')
@section('product-content')
    <form class="form-update" action="{{ route('admin.products.usage.store', $product->id) }}" method="POST" id="usageForm">
        @csrf
        <input type="hidden" name="step" value="usage">

        <h2>Применение товара: {{ $product->title }}</h2>

        <div class="form-inputs">
            <div class="form-input">
                <p class="text-medium">Необязательный этап</p>
                <div id="usages-container">
                    @php
                        $usages = old('usages', $product->usages ? $product->usages->pluck('title')->toArray() : ['']);
                        if (empty($usages)) {
                            $usages = [''];
                        }
                    @endphp
                    @foreach ($usages as $index => $usage)
                        <div class="usage-item item">
                            <label class="text-medium" for="usage-{{ $index }}">Область применения <span
                                    style="color: red;">*</span></label>
                            <input type="text" id="usage-{{ $index }}" name="usages[]" class="input-white"
                                value="{{ $usage }}" placeholder="Например: Жилые помещения">
                            <button type="button" class="button-transparent remove-item">Удалить</button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-input">
                <button type="button" id="add-usage" class="button-transparent">+ Добавить</button>
            </div>
            <div id="usageErrors" class="error-container"></div>
        </div>

        <div class="admin-buttons">
            <button type="submit" class="button-red">Сохранить и продолжить</button>
            <button type="button" class="button-transparent" id="saveAndExitButton">Сохранить и выйти</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usagesContainer = document.getElementById('usages-container');

            // Функция для добавления нового поля
            function addUsageField(value = '') {
                const div = document.createElement('div');
                div.className = 'usage-item item';
                const newIndex = usagesContainer.querySelectorAll('.usage-item').length;
                div.innerHTML = `
                    <label class="text-medium" for="usage-${newIndex}">Область применения <span style="color: red;">*</span></label>
                    <input type="text" id="usage-${newIndex}" name="usages[]" class="input-white"
                        value="${value}" placeholder="Например: Жилые помещения">
                    <button type="button" class="button-transparent remove-item">Удалить</button>
                `;
                usagesContainer.appendChild(div);
                return div;
            }

            // Добавление нового поля применения
            document.getElementById('add-usage').addEventListener('click', function() {
                addUsageField();
            });

            // Удаление поля применения
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    const items = usagesContainer.querySelectorAll('.usage-item');

                    if (items.length === 1) {
                        // Если удаляется последнее поле - очищаем его вместо удаления
                        const input = items[0].querySelector('input');
                        input.value = '';
                        input.focus();
                    } else {
                        // Удаляем поле и обновляем индексы
                        if (confirm('Вы уверены, что хотите удалить эту область применения?')) {
                            e.target.closest('.item').remove();
                            // Обновляем ID после удаления
                            usagesContainer.querySelectorAll('.usage-item').forEach((item, index) => {
                                const label = item.querySelector('label');
                                const input = item.querySelector('input');
                                label.setAttribute('for', `usage-${index}`);
                                input.setAttribute('id', `usage-${index}`);
                            });
                        }
                    }
                }
            });

            // Обработка сохранения и выхода
            document.getElementById('saveAndExitButton').addEventListener('click', function() {
                document.querySelector('input[name="step"]').value = 'complete';
                document.getElementById('usageForm').submit();
            });

            // Модифицированная валидация формы
            setupFormValidation('usageForm', function() {
                const fields = [];
                const usages = document.querySelectorAll('input[name="usages[]"]');

                usages.forEach(input => {
                    if (input.value.trim() !== '') {
                        fields.push({
                            el: input,
                            message: 'Заполните область применения'
                        });
                    }
                });

                return fields;
            }, {
                checkImages: false,
                editorRequired: false
            });
        });
    </script>
@endsection
