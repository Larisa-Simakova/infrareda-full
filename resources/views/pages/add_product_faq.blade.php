@extends('pages.add_product_base')
@section('product-content')
    <form class="form-update" action="{{ route('admin.products.faq.store', $product->id) }}" method="POST"
        id="faqForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" value="faq">

        <h2>FAQ товара: {{ $product->title }}</h2>

        <div class="form-inputs">
            <div class="form-input">
                <p class="text-medium">Необязательный этап</p>
                <div id="faq-container">
                    @php
                        $faqs = old('faqs', $product->faqs ?? []);
                        // Всегда показываем хотя бы один блок
                        if (empty($faqs)) {
                            $faqs = [
                                [
                                    'question' => '',
                                    'answer' => '',
                                ],
                            ];
                        }
                    @endphp

                    @foreach ($faqs as $index => $faq)
                        <div class="faq-item item" data-index="{{ $index }}">
                            <div class="form-input">
                                <label class="text-medium" for="faq-question-{{ $index }}">Вопрос</label>
                                <input type="text" id="faq-question-{{ $index }}"
                                    name="faqs[{{ $index }}][question]" class="input-white"
                                    value="{{ $faq['question'] ?? '' }}" placeholder="Введите вопрос">
                            </div>

                            <div class="form-input">
                                <label class="text-medium" for="faq-answer-{{ $index }}">Ответ</label>
                                <textarea id="faq-answer-{{ $index }}" name="faqs[{{ $index }}][answer]"
                                    class="input-white froala-editor" placeholder="Введите ответ">{{ $faq['answer'] ?? '' }}</textarea>
                            </div>

                            <button type="button" class="button-transparent remove-item">Удалить вопрос</button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-input">
                <button type="button" id="add-faq" class="button-transparent">+ Добавить вопрос</button>
            </div>
        </div>

        <div class="admin-buttons">
            <button type="submit" class="button-red">Сохранить и продолжить</button>
            <button type="button" class="button-transparent" id="saveAndExitButton">Сохранить и выйти</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqContainer = document.getElementById('faq-container');
            const froalaEditors = {};

            // Инициализация редакторов для существующих FAQ
            document.querySelectorAll('.faq-item').forEach(item => {
                const index = item.dataset.index;
                froalaEditors[index] = initFroalaEditor(
                    `#faq-answer-${index}`,
                    '{{ route('admin.products.images.upload') }}'
                );
            });

            // Инициализация - добавляем один блок, если нет существующих
            if (faqContainer.querySelectorAll('.faq-item').length === 0) {
                addFaqField();
            }

            // Функция для добавления нового поля FAQ
            function addFaqField(data = {}) {
                const newIndex = faqContainer.querySelectorAll('.faq-item').length;
                const div = document.createElement('div');
                div.className = 'faq-item item';
                div.dataset.index = newIndex;

                div.innerHTML = `
                    <div class="form-input">
                        <label class="text-medium" for="faq-question-${newIndex}">Вопрос</label>
                        <input type="text" id="faq-question-${newIndex}"
                               name="faqs[${newIndex}][question]" class="input-white"
                               value="${data.question || ''}" placeholder="Введите вопрос">
                    </div>

                    <div class="form-input">
                        <label class="text-medium" for="faq-answer-${newIndex}">Ответ</label>
                        <textarea id="faq-answer-${newIndex}" name="faqs[${newIndex}][answer]"
                                  class="input-white froala-editor" placeholder="Введите ответ">${data.answer || ''}</textarea>
                    </div>

                    <button type="button" class="button-transparent remove-item">Удалить вопрос</button>
                `;

                faqContainer.appendChild(div);

                // Инициализация редактора для нового FAQ
                froalaEditors[newIndex] = initFroalaEditor(
                    `#faq-answer-${newIndex}`,
                    '{{ route('admin.products.images.upload') }}'
                );
            }

            // Добавление нового FAQ
            document.getElementById('add-faq').addEventListener('click', function() {
                addFaqField();
            });

            // Удаление FAQ
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    const items = faqContainer.querySelectorAll('.faq-item');

                    if (items.length === 1) {
                        // Если удаляется последнее поле - очищаем его вместо удаления
                        const inputs = items[0].querySelectorAll('input, textarea');
                        inputs.forEach(input => {
                            input.value = '';
                        });

                        // Очищаем редактор
                        const editor = froalaEditors[items[0].dataset.index];
                        if (editor) {
                            editor.html.set('');
                        }
                    } else {
                        if (confirm('Вы уверены, что хотите удалить этот вопрос?')) {
                            const item = e.target.closest('.faq-item');
                            delete froalaEditors[item.dataset.index];
                            item.remove();
                        }
                    }
                }
            });

            // Обработка сохранения и выхода
            document.getElementById('saveAndExitButton').addEventListener('click', function() {
                document.querySelector('input[name="step"]').value = 'complete';
                document.getElementById('faqForm').submit();
            });

            // Валидация формы
            setupOptionalFormValidation('faqForm', function() {
                const fields = [];
                let hasFilledFields = false;

                document.querySelectorAll('.faq-item').forEach(item => {
                    const index = item.dataset.index;
                    const question = item.querySelector(`input[name="faqs[${index}][question]"]`);
                    const answerEditor = froalaEditors[index];

                    const isFilled = question.value.trim() !== '' ||
                                   (answerEditor && answerEditor.html.get().trim() !== '' &&
                                    answerEditor.html.get() !== '<p><br></p>');

                    if (isFilled) {
                        hasFilledFields = true;

                        if (question.value.trim() === '') {
                            fields.push({
                                el: question,
                                message: 'Заполните вопрос'
                            });
                        }

                        if (!answerEditor || answerEditor.html.get().trim() === '' ||
                            answerEditor.html.get() === '<p><br></p>') {
                            fields.push({
                                el: item.querySelector(`textarea[name="faqs[${index}][answer]"]`),
                                message: 'Заполните ответ'
                            });
                        }
                    }
                });

                return hasFilledFields ? fields : [];
            });
        });
    </script>
@endsection
