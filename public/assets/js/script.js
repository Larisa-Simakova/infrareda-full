document.addEventListener('DOMContentLoaded', function () {
    const swiperInstances = {};

    document.querySelectorAll('.swiper-container').forEach(container => {
        const swiperId = container.id || 'swiper-' + Math.random().toString(36).substr(2, 9);
        container.dataset.swiperId = swiperId;

        const swiper = new Swiper(container, {
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: container.querySelector('.custom-pagination'),
                type: 'bullets',
                clickable: true,
            },
            breakpoints: {
                1036: { slidesPerView: 3, slidesPerGroup: 3 },
                633: { slidesPerView: 2, slidesPerGroup: 2 },
                320: { slidesPerView: 1, slidesPerGroup: 1 }
            },
            on: {
                init: function () { startProgressAnimation(this) },
                slideChange: function () {
                    resetProgressAnimation(this);
                    startProgressAnimation(this);
                }
            }
        });

        swiperInstances[swiperId] = swiper;
    });

    // Экспортируем функцию для доступа к Swiper-экземплярам
    window.getSwiperInstance = (container) => {
        return swiperInstances[container.dataset.swiperId];
    };

    // Функции анимации прогресса
    function startProgressAnimation(swiper) {
        const bullets = swiper.pagination.bullets;
        const activeIndex = Math.floor(swiper.realIndex / swiper.params.slidesPerGroup);

        bullets.forEach(bullet => {
            bullet.classList.remove('active');
            bullet.style.animation = 'none';
        });

        if (bullets[activeIndex]) {
            bullets[activeIndex].classList.add('active');
            bullets[activeIndex].style.animation = `progress ${swiper.params.autoplay.delay}ms linear`;
        }
    }

    function resetProgressAnimation(swiper) {
        swiper.pagination.bullets.forEach(bullet => {
            bullet.classList.remove('active');
            bullet.style.animation = 'none';
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const slider = new Swiper('.swiper-container-img', {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 0,
        loop: true,

        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },

        pagination: {
            el: '.custom-pagination',
            type: 'bullets',
            clickable: true,
        },


        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },

        on: {
            init: function () {
                startProgressAnimation(this);
            },
            slideChange: function () {
                resetProgressAnimation(this);
                startProgressAnimation(this);
            },
        }
    });

    function startProgressAnimation(swiper) {
        const bullets = swiper.pagination.bullets;
        const activeIndex = swiper.realIndex;

        bullets.forEach(bullet => {
            bullet.classList.remove('active');
            bullet.style.animation = 'none';
        });

        if (bullets[activeIndex]) {
            bullets[activeIndex].classList.add('active');
            bullets[activeIndex].style.animation = `progress ${swiper.params.autoplay.delay}ms linear`;
        }
    }

    function resetProgressAnimation(swiper) {
        swiper.pagination.bullets.forEach(bullet => {
            bullet.classList.remove('active');
            bullet.style.animation = 'none';
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Инициализация Choices с улучшенными настройками
    const choices = new Choices('.js-choice', {
        searchEnabled: false,
        itemSelectText: '',
        shouldSort: false,
        position: 'auto', // Автоматическое позиционирование dropdown
        classNames: {
            containerOuter: 'choices',
            containerInner: 'choices__inner',
            input: 'choices__input',
            item: 'choices__item',
            list: 'choices__list',
            listDropdown: 'choices__list--dropdown',
        },
        callbackOnCreateTemplates: function (template) {
            return {
                item: (classNames, data) => {
                    return template(`
                        <div class="${classNames.item} ${data.highlighted ? classNames.highlightedState : classNames.itemSelectable}"
                            data-item data-id="${data.id}" data-value="${data.value}" ${data.active ? 'aria-selected="true"' : ''}
                            ${data.disabled ? 'aria-disabled="true"' : ''}>
                            ${data.label}
                        </div>
                    `);
                }
            };
        }
    });

    // Функция для обновления ширины селекта
    function updateSelectWidth() {
        const select = document.querySelector('.js-choice');
        if (!select) return;

        const choicesContainer = select.closest('.choices');
        const selectedItem = choicesContainer.querySelector('.choices__item');

        if (selectedItem) {
            // Создаем временный элемент для измерения текста
            const tempSpan = document.createElement('span');
            tempSpan.style.visibility = 'hidden';
            tempSpan.style.whiteSpace = 'nowrap';
            tempSpan.style.position = 'absolute';
            tempSpan.style.fontSize = window.getComputedStyle(selectedItem).fontSize;
            tempSpan.style.fontFamily = window.getComputedStyle(selectedItem).fontFamily;
            tempSpan.textContent = selectedItem.textContent;

            document.body.appendChild(tempSpan);
            const textWidth = tempSpan.offsetWidth;
            document.body.removeChild(tempSpan);

            // Устанавливаем ширину с учетом padding и стрелки
            const newWidth = Math.min(Math.max(textWidth + 60, 150), window.innerWidth - 40);
            choicesContainer.style.width = `${newWidth}px`;
        }
    }

    // Обновляем при инициализации и изменении значения
    updateSelectWidth();
    choices.passedElement.element.addEventListener('change', updateSelectWidth);

    // Обновляем при ресайзе окна с debounce
    let resizeTimeout;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updateSelectWidth, 100);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    if (!form) return;

    const phoneInput = form.querySelector('input[type="tel"]');

    // Инициализация маски телефона
    const phoneMask = IMask(phoneInput, {
        mask: '+{7} (000) 000-00-00',
        lazy: false
    });

    // Устанавливаем начальное значение
    phoneMask.value = '+7 (';
    phoneMask.updateValue();

    // Валидация формы
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        let isValid = true;

        // Валидация имени
        const name = form.elements.name.value.trim();
        if (!name) {
            showError('name-error', 'Пожалуйста, введите ваше имя');
            form.elements.name.classList.add('invalid');
            isValid = false;
        }

        // Валидация телефона
        const phoneDigits = phoneMask.unmaskedValue;
        if (!phoneDigits || phoneDigits.length < 10) {
            showError('phone-error', 'Пожалуйста, введите полный номер телефона');
            phoneInput.classList.add('invalid');
            isValid = false;
        }

        // Валидация чекбокса
        if (!form.elements.policy.checked) {
            showError('policy-error', 'Необходимо подтвердить согласие');
            isValid = false;
        }

        if (!isValid) {
            const firstError = document.querySelector('.error-message[style*="display: block"]');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // Отправка формы
        submitForm();
    });

    // Функция отправки формы
    async function submitForm() {
        const formData = new FormData(form);
        const phoneDigits = phoneMask.unmaskedValue;
        formData.set('phone', '+7' + phoneDigits);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const result = await response.json();

            if (response.ok) {
                showNotification('Заявка на звонок успешно отправлена!', 'success');
                form.reset();
                phoneMask.value = '+7 (';
                phoneMask.updateValue();
            } else {
                throw new Error(result.message || 'Ошибка сервера');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            showNotification('Произошла ошибка при отправке: ' + error.message, 'error');
        }
    }

    // Функции для работы с ошибками
    function showError(id, message) {
        const errorElement = document.getElementById(id);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
        document.querySelectorAll('.input-transparent').forEach(el => {
            el.classList.remove('invalid');
        });
    }

    // Очистка ошибок при вводе
    form.elements.name.addEventListener('input', function () {
        this.classList.remove('invalid');
        document.getElementById('name-error').style.display = 'none';
    });

    phoneInput.addEventListener('input', function () {
        this.classList.remove('invalid');
        document.getElementById('phone-error').style.display = 'none';
    });

    form.elements.policy.addEventListener('change', function () {
        document.getElementById('policy-error').style.display = 'none';
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Инициализация модального окна
    const modal = document.getElementById('callbackModal');
    const openModalBtnHeader = document.querySelector('.header .button-red'); // Кнопка в шапке
    const openModalBtnFooter = document.querySelector('.footer .button-red'); // Кнопка в подвале
    const closeModalBtn = document.querySelector('.modal__close');
    const callbackForm = document.getElementById('callbackForm');

    // Обработчик для кнопки в шапке
    if (openModalBtnHeader) {
        openModalBtnHeader.addEventListener('click', function (e) {
            e.preventDefault();
            showModal();
        });
    }

    // Обработчик для кнопки в подвале
    if (openModalBtnFooter) {
        openModalBtnFooter.addEventListener('click', function (e) {
            e.preventDefault();
            showModal();
        });
    }

    // Функция для отображения модального окна
    function showModal() {
        modal.style.display = 'block';
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
        document.body.classList.add('modal-open');
    }

    // Закрытие модального окна
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function () {
            closeModal();
        });
    }

    // Закрытие по клику вне модального окна
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Функция для закрытия модального окна
    function closeModal() {
        modal.classList.remove('active');
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    }

    // Инициализация маски телефона в модальном окне
    const modalPhoneInput = callbackForm.querySelector('input[type="tel"]');
    const modalPhoneMask = IMask(modalPhoneInput, {
        mask: '+{7} (000) 000-00-00',
        lazy: false
    });
    modalPhoneMask.value = '+7 (';
    modalPhoneMask.updateValue();

    // Обработка отправки формы в модальном окне
    callbackForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearModalErrors();

        let isValid = true;

        // Валидация имени
        const name = callbackForm.elements.name.value.trim();
        if (!name) {
            showModalError('modal-name-error', 'Пожалуйста, введите ваше имя');
            callbackForm.elements.name.classList.add('invalid');
            isValid = false;
        }

        // Валидация телефона
        const phoneDigits = modalPhoneMask.unmaskedValue;
        if (!phoneDigits || phoneDigits.length < 10) {
            showModalError('modal-phone-errorr', 'Пожалуйста, введите полный номер телефона');
            modalPhoneInput.classList.add('invalid');
            isValid = false;
        }

        // Валидация чекбокса
        if (!callbackForm.elements.policy.checked) {
            showModalError('modal-policy-error', 'Необходимо подтвердить согласие');
            isValid = false;
        }

        if (!isValid) return;

        // Отправка формы
        try {
            const formData = new FormData(callbackForm);
            const phoneDigits = modalPhoneMask.unmaskedValue;
            formData.set('phone', '+7' + phoneDigits);

            const response = await fetch(window.contactFormRoute, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const result = await response.json();

            if (response.ok) {
                showNotification('Заявка на звонок успешно отправлена!', 'success');
                callbackForm.reset();
                modalPhoneMask.value = '+7 (';
                modalPhoneMask.updateValue();
                modal.classList.remove('active');
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
            } else {
                throw new Error(result.message || 'Ошибка сервера');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            showNotification('Произошла ошибка при отправке: ' + error.message, 'error');
        }
    });

    // Функции для работы с модальным окном
    function showModalError(id, message) {
        const errorElement = document.getElementById(id);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    function clearModalErrors() {
        document.querySelectorAll('#callbackForm .error').forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
        document.querySelectorAll('#callbackForm .input-transparent').forEach(el => {
            el.classList.remove('invalid');
        });
    }

    // Очистка ошибок при вводе
    callbackForm.elements.name.addEventListener('input', function () {
        this.classList.remove('invalid');
        document.getElementById('modal-name-error').style.display = 'none';
    });

    modalPhoneInput.addEventListener('input', function () {
        this.classList.remove('invalid');
        document.getElementById('modal-phone-errorr').style.display = 'none';
    });

    callbackForm.elements.policy.addEventListener('change', function () {
        document.getElementById('modal-policy-error').style.display = 'none';
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Инициализация модального окна для товара
    const productModal = document.getElementById('productRequestModal');
    const productRequestForm = document.getElementById('productRequestForm');

    // Находим все кнопки "Оставить заявку" по тексту внутри span.text
    const leaveRequestButtons = Array.from(document.querySelectorAll('.button-red-arrow')).filter(btn => {
        const textSpan = btn.querySelector('.text');
        return textSpan && textSpan.textContent.trim().toLowerCase() === 'оставить заявку';
    });

    // Обработчики для кнопок "Оставить заявку"
    if (leaveRequestButtons.length) {
        leaveRequestButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                showProductModal();
            });
        });
    }

    // Функция для отображения модального окна товара
    function showProductModal() {
        // Получаем название товара из заголовка h2
        const productName = document.querySelector('section.product h2')?.textContent || 'Товар';
        document.getElementById('productName').value = productName;

        productModal.style.display = 'block';
        document.body.classList.add('modal-open');
        setTimeout(() => {
            productModal.classList.add('active');
        }, 10);

        // Инициализация маски для телефона
        const phoneInput = productModal.querySelector('input[type="tel"]');
        if (phoneInput && !phoneInput._mask) {
            phoneInput._mask = IMask(phoneInput, {
                mask: '+{7} (000) 000-00-00',
                lazy: false
            });
            phoneInput._mask.value = '+7 (';
            phoneInput._mask.updateValue();
        }
    }

    // Закрытие модального окна
    const closeModalBtn = productModal.querySelector('.modal__close');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeProductModal);
    }

    // Закрытие по клику вне модального окна
    productModal.addEventListener('click', function (e) {
        if (e.target === productModal) {
            closeProductModal();
        }
    });

    // Функция для закрытия модального окна
    function closeProductModal() {
        productModal.style.display = 'none';
        document.body.classList.remove('modal-open');
    }

    // Обработка отправки формы
    if (productRequestForm) {
        productRequestForm.addEventListener('submit', function (e) {
            e.preventDefault();
            clearProductModalErrors();

            let isValid = true;

            // Валидация имени
            const name = productRequestForm.elements.name.value.trim();
            if (!name) {
                showProductModalError('product-request-name-error', 'Пожалуйста, введите ваше имя');
                productRequestForm.elements.name.classList.add('invalid');
                isValid = false;
            }

            // Валидация телефона
            const phoneInput = productRequestForm.querySelector('input[type="tel"]');
            const phoneDigits = phoneInput?._mask?.unmaskedValue;
            if (!phoneDigits || phoneDigits.length < 10) {
                showProductModalError('product-request-phone-error', 'Пожалуйста, введите полный номер телефона');
                phoneInput.classList.add('invalid');
                isValid = false;
            }

            // Валидация чекбокса
            if (!productRequestForm.elements.policy.checked) {
                showProductModalError('product-request-policy-error', 'Необходимо подтвердить согласие');
                isValid = false;
            }

            if (!isValid) return;

            // Подготовка данных для отправки
            const formData = new FormData(productRequestForm);
            formData.set('phone', '+7' + phoneDigits);

            // Отправка формы
            fetch(window.contactFormRoute, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showNotification('Заявка на товар успешно отправлена!', 'success');
                        productRequestForm.reset();
                        if (phoneInput._mask) {
                            phoneInput._mask.value = '+7 (';
                            phoneInput._mask.updateValue();
                        }
                        closeProductModal();
                    } else {
                        throw new Error(result.message || 'Ошибка сервера');
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    showNotification('Произошла ошибка при отправке: ' + error.message, 'error');
                });
        });
    }

    // Функции для работы с ошибками
    function showProductModalError(id, message) {
        const errorElement = document.getElementById(id);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    function clearProductModalErrors() {
        productModal.querySelectorAll('.error').forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
        productModal.querySelectorAll('.input-transparent').forEach(el => {
            el.classList.remove('invalid');
        });
    }

    // Очистка ошибок при вводе
    productModal.querySelector('input[name="name"]')?.addEventListener('input', function () {
        this.classList.remove('invalid');
        document.getElementById('product-request-name-error').style.display = 'none';
    });

    productModal.querySelector('input[type="tel"]')?.addEventListener('input', function () {
        this.classList.remove('invalid');
        document.getElementById('product-request-phone-error').style.display = 'none';
    });

    productModal.querySelector('input[name="policy"]')?.addEventListener('change', function () {
        document.getElementById('product-request-policy-error').style.display = 'none';
    });
});

// Вспомогательная функция для поиска по тексту (аналог jQuery :contains)
function contains(selector, text) {
    const elements = document.querySelectorAll(selector);
    return Array.prototype.filter.call(elements, function (element) {
        return RegExp(text).test(element.textContent);
    });
}

// Добавляем метод closest для поддержки старых браузеров
if (!Element.prototype.matches) {
    Element.prototype.matches = Element.prototype.msMatchesSelector ||
        Element.prototype.webkitMatchesSelector;
}

if (!Element.prototype.closest) {
    Element.prototype.closest = function (s) {
        let el = this;
        do {
            if (el.matches(s)) return el;
            el = el.parentElement || el.parentNode;
        } while (el !== null && el.nodeType === 1);
        return null;
    };
}


window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (window.scrollY > 60) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});


// Dynamic Adapt v.1
// HTML data-da="where(uniq class name),when(breakpoint),position(digi)"
// e.x. data-da=".item,992,2"

"use strict";
function DynamicAdapt(type) {
    this.type = type;
}
DynamicAdapt.prototype.init = function () {
    const _this = this;
    // массив объектов
    this.оbjects = [];
    this.daClassname = "_dynamic_adapt_";
    // массив DOM-элементов
    this.nodes = document.querySelectorAll("[data-da]");
    // наполнение оbjects объектами
    for (let i = 0; i < this.nodes.length; i++) {
        const node = this.nodes[i];
        const data = node.dataset.da.trim();
        const dataArray = data.split(",");
        const оbject = {};
        оbject.element = node;
        оbject.parent = node.parentNode;
        оbject.destination = document.querySelector(dataArray[0].trim());
        оbject.breakpoint = dataArray[1] ? dataArray[1].trim() : "767";
        оbject.place = dataArray[2] ? dataArray[2].trim() : "last";
        оbject.index = this.indexInParent(оbject.parent, оbject.element);
        this.оbjects.push(оbject);
    }
    this.arraySort(this.оbjects);
    // массив уникальных медиа-запросов
    this.mediaQueries = Array.prototype.map.call(this.оbjects, function (item) {
        return '(' + this.type + "-width: " + item.breakpoint + "px)," + item.breakpoint;
    }, this);
    this.mediaQueries = Array.prototype.filter.call(this.mediaQueries, function (item, index, self) {
        return Array.prototype.indexOf.call(self, item) === index;
    });
    // навешивание слушателя на медиа-запрос
    // и вызов обработчика при первом запуске
    for (let i = 0; i < this.mediaQueries.length; i++) {
        const media = this.mediaQueries[i];
        const mediaSplit = String.prototype.split.call(media, ',');
        const matchMedia = window.matchMedia(mediaSplit[0]);
        const mediaBreakpoint = mediaSplit[1];
        // массив объектов с подходящим брейкпоинтом
        const оbjectsFilter = Array.prototype.filter.call(this.оbjects, function (item) {
            return item.breakpoint === mediaBreakpoint;
        });
        matchMedia.addListener(function () {
            _this.mediaHandler(matchMedia, оbjectsFilter);
        });
        this.mediaHandler(matchMedia, оbjectsFilter);
    }
};
DynamicAdapt.prototype.mediaHandler = function (matchMedia, оbjects) {
    if (matchMedia.matches) {
        for (let i = 0; i < оbjects.length; i++) {
            const оbject = оbjects[i];
            оbject.index = this.indexInParent(оbject.parent, оbject.element);
            this.moveTo(оbject.place, оbject.element, оbject.destination);
        }
    } else {
        //for (let i = 0; i < оbjects.length; i++) {
        for (let i = оbjects.length - 1; i >= 0; i--) {
            const оbject = оbjects[i];
            if (оbject.element.classList.contains(this.daClassname)) {
                this.moveBack(оbject.parent, оbject.element, оbject.index);
            }
        }
    }
};
// Функция перемещения
DynamicAdapt.prototype.moveTo = function (place, element, destination) {
    element.classList.add(this.daClassname);
    if (place === 'last' || place >= destination.children.length) {
        destination.insertAdjacentElement('beforeend', element);
        return;
    }
    if (place === 'first') {
        destination.insertAdjacentElement('afterbegin', element);
        return;
    }
    destination.children[place].insertAdjacentElement('beforebegin', element);
}
// Функция возврата
DynamicAdapt.prototype.moveBack = function (parent, element, index) {
    element.classList.remove(this.daClassname);
    if (parent.children[index] !== undefined) {
        parent.children[index].insertAdjacentElement('beforebegin', element);
    } else {
        parent.insertAdjacentElement('beforeend', element);
    }
}
// Функция получения индекса внутри родителя
DynamicAdapt.prototype.indexInParent = function (parent, element) {
    const array = Array.prototype.slice.call(parent.children);
    return Array.prototype.indexOf.call(array, element);
};
// Функция сортировки массива по breakpoint и place
// по возрастанию для this.type = min
// по убыванию для this.type = max
DynamicAdapt.prototype.arraySort = function (arr) {
    if (this.type === "min") {
        Array.prototype.sort.call(arr, function (a, b) {
            if (a.breakpoint === b.breakpoint) {
                if (a.place === b.place) {
                    return 0;
                }

                if (a.place === "first" || b.place === "last") {
                    return -1;
                }

                if (a.place === "last" || b.place === "first") {
                    return 1;
                }

                return a.place - b.place;
            }

            return a.breakpoint - b.breakpoint;
        });
    } else {
        Array.prototype.sort.call(arr, function (a, b) {
            if (a.breakpoint === b.breakpoint) {
                if (a.place === b.place) {
                    return 0;
                }

                if (a.place === "first" || b.place === "last") {
                    return 1;
                }

                if (a.place === "last" || b.place === "first") {
                    return -1;
                }

                return b.place - a.place;
            }

            return b.breakpoint - a.breakpoint;
        });
        return;
    }
};
const da = new DynamicAdapt("max");
da.init();

/*Loading================================================================================*/
window.addEventListener('load', function () {
    const loader = document.querySelector('.loader');
    loader.classList.add('hidden');
});

/*Content_download================================================================================*/
let wrapper = document.querySelector('.wrapper');
window.addEventListener('load', (event) => {
    wrapper.classList.add('loaded');
});

//burger=====================================================================================================================================================
const iconMenu = document.querySelector('.icon-menu');
const menuBody = document.querySelector('.header__body');
const body = document.querySelector('body');

if (iconMenu) {
    iconMenu.addEventListener('click',
        function clickButtonBurger(event) {
            iconMenu.classList.toggle('active');
            menuBody.classList.toggle('active');
            body.classList.toggle('lock');
        });
}

const accordionHeaders = document.querySelectorAll('.accordion-item');
accordionHeaders.forEach(header => {
    header.addEventListener('click', () => {
        currentActiveHeader = document.querySelector('.accordion-item.active');
        if (currentActiveHeader && currentActiveHeader != header) {
            currentActiveHeader.classList.remove('active');
            currentActiveHeader.querySelector('.accordion-content').classList.remove('active');
        }
        header.classList.toggle('active');
        header.querySelector('.accordion-content').classList.toggle('active');
    })
});

document.addEventListener('DOMContentLoaded', function () {
    function adjustTextareaHeight(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    const textareas = document.querySelectorAll('textarea.input-white');

    textareas.forEach(textarea => {
        adjustTextareaHeight(textarea);

        textarea.addEventListener('input', function () {
            adjustTextareaHeight(this);
        });

        const observer = new MutationObserver(function () {
            adjustTextareaHeight(textarea);
        });

        observer.observe(textarea, {
            childList: true,
            subtree: true,
            characterData: true
        });
    });
});
