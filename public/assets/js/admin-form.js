// Общие функции
function showError(element, message) {
    element.classList.add('input-error');
    const error = document.createElement('div');
    error.className = 'error error-text text-small';
    error.textContent = message;
    element.parentNode.insertBefore(error, element.nextSibling);
    return false;
}

window.validateDate = function (dateInput) {
    const value = dateInput.value.trim();
    if (!value) return 'Заполните поле';

    const inputDate = new Date(value);
    const currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);

    if (isNaN(inputDate.getTime())) return 'Некорректная дата';
    if (inputDate < new Date('2000-01-01')) return 'Дата не может быть раньше 2000 года';
    if (inputDate > currentDate) return 'Дата не может быть в будущем';

    return null;
}

window.validateNumber = function (input, customMessage) {
    if (!input) return 'Элемент не найден';
    const value = input.value;

    if (value === null || value === undefined || value === '') {
        return 'Заполните поле'
    }

    if (isNaN(Number(value))) {
        return customMessage || 'Поле должно быть числовым значением';
    }
    return null;
}


// Объект для хранения состояния загрузчиков изображений
const imageUploadManager = {
    isDeleting: false,
    setupImageUpload: function (uploadInputId, imagesContainerId, uploadRoute, deleteRoute, options = {}) {
        const uploadInput = document.getElementById(uploadInputId);
        if (!uploadInput) return;

        // Обработчик загрузки изображений
        uploadInput.addEventListener('change', function (e) {
            const files = this.files;
            const errorContainer = this.closest('.form-input').querySelector('.error-container') || document.getElementById('imageErrors');
            errorContainer.innerHTML = '';

            if (!files || files.length === 0) return;

            const validFormats = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg+xml'];
            let hasInvalidFiles = false;
            let errorMessage = '';

            Array.from(files).forEach(file => {
                if (!file.type.match('image.*')) {
                    hasInvalidFiles = true;
                    errorMessage = 'Файл должен быть изображением';
                } else if (!validFormats.includes(file.type)) {
                    hasInvalidFiles = true;
                    errorMessage = 'Допустимые форматы: PNG, JPG, JPEG, WEBP, SVG';
                } else if (file.size > 5 * 1024 * 1024) {
                    hasInvalidFiles = true;
                    errorMessage = 'Максимальный размер файла: 5MB';
                }
            });

            if (hasInvalidFiles) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error text-small';
                errorDiv.textContent = errorMessage;
                errorContainer.appendChild(errorDiv);
                this.value = '';
                return;
            }

            const formData = new FormData();
            Array.from(files).forEach(file => {
                formData.append('images[]', file);
            });
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            if (options.imageType) {
                formData.append('image_type', options.imageType);
            }

            const loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'text-small';
            loadingIndicator.textContent = 'Загрузка...';
            errorContainer.appendChild(loadingIndicator);

            fetch(uploadRoute, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        if (response.status === 422 && data.errors) {
                            const errors = Object.values(data.errors).flat();
                            throw new Error(errors.join(', '));
                        }
                        throw new Error(data.message || 'Ошибка сервера');
                    }
                    return data;
                })
                .then(data => {
                    loadingIndicator.remove();
                    if (data.success) {
                        const container = document.getElementById(imagesContainerId);

                        data.images.forEach(image => {
                            const div = document.createElement('div');
                            div.className = 'image-block';
                            div.dataset.temp = image.temp_id;
                            div.innerHTML = `
                            <img src="${image.url}" alt="Preview">
                            <button type="button" class="button-transparent delete-image"
                                    data-temp="${image.temp_id}"
                                    data-container="${imagesContainerId}"
                                    data-type="${options.imageType || ''}"
                                    data-delete-route="${deleteRoute}">
                                Удалить фото
                            </button>
                            <input type="hidden" name="uploaded_images[]" value="${image.temp_id}">
                        `;
                            container.appendChild(div);
                        });
                        this.value = '';
                    }
                })
                .catch(error => {
                    loadingIndicator.remove();
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error text-small';
                    errorDiv.textContent = error.message || 'Ошибка при загрузке изображений';
                    errorContainer.appendChild(errorDiv);
                });
        });
    }
};

// Экспортируем функцию для использования в других файлах
window.setupImageUpload = imageUploadManager.setupImageUpload;

// Обновленная функция инициализации редактора
window.initFroalaEditor = function (selector, uploadRoute) {
    const editorConfig = {
        fontFamily: {
            "Manrope, sans-serif": 'Manrope',
            "Arial, Helvetica, sans-serif": 'Arial',
            "Georgia, serif": 'Georgia',
            "Impact, Charcoal, sans-serif": 'Impact',
            "Tahoma, Geneva, sans-serif": 'Tahoma',
            "'Times New Roman', Times, serif": 'Times New Roman',
            "Verdana, Geneva, sans-serif": 'Verdana'
        },
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'textColor',
                    'backgroundColor', 'clearFormatting'
                ]
            },
            moreParagraph: {
                buttons: ['alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'formatOL', 'formatUL',
                    'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent'
                ]
            },
            moreRich: {
                buttons: ['insertLink', 'insertImage', 'insertTable', 'emoticons', 'specialCharacters']
            },
            moreMisc: {
                buttons: ['undo', 'redo', 'fullscreen', 'selectAll', 'html']
            }
        },
        paragraphStyles: {
            'custom-h1': 'Заголовок 1',
            'custom-h2': 'Заголовок 2',
        },
        paragraphDefaultSelection: 'paragraph-normal',
        toolbarButtonsXS: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize',
            'textColor', 'backgroundColor', 'formatUL', 'formatOL', 'insertImage', 'undo', 'redo'
        ],
        imageEditButtons: ['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen',
            'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'
        ],
        imageUploadURL: uploadRoute,
        imageUploadParams: {
            '_token': document.querySelector('meta[name="csrf-token"]').content
        },
        imageAllowedTypes: ['jpeg', 'jpg', 'png', 'svg', 'webp'],
        language: 'ru',
        placeholderText: 'Введите описание...',
        events: {
            initialized: function () {
                // Добавляем стиль для шрифта Manrope
                const style = document.createElement('style');
                style.textContent = `
                    .fr-element {
                        font-family: 'Manrope', sans-serif;
                    }
                    .fr-view p, .fr-view li {
                        font-family: 'Manrope', sans-serif;
                    }
                `;
                document.head.appendChild(style);

                this.$el.find('p:not([class])').addClass('paragraph-normal');
                this.$el.find('li:not([class])').addClass('paragraph-normal');

                // Сохраняем ссылки на редакторы
                if (selector === '#short-editor') {
                    window.shortEditor = this;
                } else {
                    window.editor = this;
                }

                // Автоматическая высота
                const updateHeight = () => {
                    const editorElement = this.$el;
                    editorElement.css('height', 'auto');
                    editorElement.css('height', editorElement[0].scrollHeight + 'px');
                };

                updateHeight();
                this.events.on('contentChanged', updateHeight);
                window.addEventListener('resize', updateHeight);

                // Синхронизация с textarea
                this.events.on('contentChanged', () => {
                    const textarea = document.querySelector(selector);
                    if (textarea) {
                        textarea.value = this.html.get();
                    }
                });
            },
            'image.beforeUpload': function (images) { return true; },
            'image.uploaded': function (response) {
                if (response.code && response.code === 200) {
                    return JSON.parse(response);
                }
                return false;
            },
            'image.error': function (error, response) {
                console.error('Ошибка загрузки изображения:', error, response);
            }
        }
    };

    // Упрощенный тулбар для короткого описания
    if (selector === '#short-editor') {
        editorConfig.placeholderText = 'Введите краткое описание...';
    }

    return new FroalaEditor(selector, editorConfig);
};

// Обновленная функция валидации формы
window.setupFormValidation = function (formId, fields, options = {}) {
    const form = document.getElementById(formId);
    if (!form) return;

    const {
        editorRequired = false,
        checkImages = false,
        errorMessage = 'Необходимо загрузить хотя бы одно изображение',
        skipValidation = false
    } = options;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Сброс предыдущих ошибок
        document.querySelectorAll('.error-text').forEach(el => el.remove());
        document.querySelectorAll('.input-white').forEach(el => el.classList.remove('input-error'));

        let isValid = true;

        // Валидация редакторов
        if (editorRequired) {
            // Валидация основного редактора (id="editor")
            if (window.editor && window.editor.html.get().trim() === '') {
                const editorContainer = document.querySelector('#editor').closest('.form-input');
                editorContainer.classList.add('input-error');
                const error = document.createElement('div');
                error.className = 'error error-text text-small';
                error.textContent = 'Заполните поле';
                editorContainer.appendChild(error);
                isValid = false;
            }

            // Валидация короткого описания (id="short-editor")
            if (window.shortEditor && window.shortEditor.html.get().trim() === '') {
                const editorContainer = document.querySelector('#short-editor').closest('.form-input');
                editorContainer.classList.add('input-error');
                const error = document.createElement('div');
                error.className = 'error error-text text-small';
                error.textContent = 'Заполните поле';
                editorContainer.appendChild(error);
                isValid = false;
            }
        }

        // Валидация обычных полей
        const validationFields = typeof fields === 'function' ? fields() : fields;
        if (validationFields && validationFields.length > 0) {
            validationFields.forEach(field => {
                if (!field || !field.el) return;

                if (field.validator) {
                    const error = field.validator(field.el);
                    if (error) isValid = showError(field.el, error);
                } else if (!field.el.value.trim()) {
                    isValid = showError(field.el, field.message);
                }
            });
        }

        // Валидация изображений
        if (checkImages) {
            const errorContainer = document.getElementById('imageErrors') ||
                form.querySelector('.error-container');
            const hasImages = typeof checkImages === 'function'
                ? checkImages()
                : document.querySelectorAll('input[name="uploaded_images[]"]').length > 0;

            if (!hasImages) {
                errorContainer.innerHTML = `<div class="error text-small">${errorMessage}</div>`;
                isValid = false;
            }
        }

        if (isValid) {
            this.submit();
        } else {
            const firstError = document.querySelector('.error-text');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
};

window.setupOptionalFormValidation = function (formId, fieldsCallback, options = {}) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Сброс предыдущих ошибок
        document.querySelectorAll('.error-text').forEach(el => el.remove());
        document.querySelectorAll('.input-white, textarea').forEach(el => el.classList.remove('input-error'));

        let isValid = true;
        const validationFields = fieldsCallback();

        // Проверяем только если есть заполненные поля
        if (validationFields && validationFields.length > 0) {
            validationFields.forEach(field => {
                if (!field || !field.el) return;

                if (!field.el.value.trim()) {
                    isValid = showError(field.el, field.message);
                }
            });
        }

        if (isValid) {
            this.submit();
        } else {
            const firstError = document.querySelector('.input-error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
};


window.showNotification = function (message, type = 'success', duration = 3000) {
    const notification = document.getElementById('notification');
    if (!notification) return;

    notification.textContent = message;
    notification.className = 'notification';
    notification.classList.add(type);
    notification.classList.add('show');

    setTimeout(() => {
        notification.classList.remove('show');
    }, duration);
}
