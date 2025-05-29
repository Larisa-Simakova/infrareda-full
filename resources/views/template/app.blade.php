<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/fonts.css') }}">
    <link rel="shortcut icon" href="{{ secure_asset('./assets/images/logo/logo-short.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/languages/ru.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Подключаем CKEditor 5 (Classic Editor) -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <!-- Плагин для загрузки изображений -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/translations/ru.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="{{ secure_asset('assets/js/script.js') }}" defer></script>
    <script src="{{ secure_asset('assets/js/admin-form.js') }}"></script>
    <script src="{{ secure_asset('assets/js/swiper-bundle.min.js') }}"></script>
    <title>Инфрарэда</title>
</head>

<body>
    <div class="loader"></div>
    <div class="wrapper">
        @include('includes.header')
        <main>
            @yield('page')
        </main>
        @include('includes.footer')
    </div>
    <div id="notification" class="notification"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showNotification('{{ session('success')['message'] }}',
                    '{{ session('success')['type'] ?? 'success' }}');
            @endif

            @if (session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif
        });
    </script>

    <script>
        window.contactFormRoute = "{{ route('send.contact') }}";
    </script>

    <div id="callbackModal" class="modal">
        <div class="modal-content">
            <button class="modal__close">&times;</button>
            <h2>Заказать звонок</h2>
            <form id="callbackForm" class="modal__form">
                @csrf
                <div class="form__inputs">
                    <div class="form-input">
                        <label for="name" class="text-medium">Ваше имя <span style="color: red;">*</span></label>
                        <input id="name" class="input-transparent" type="text" name="name"
                            placeholder="Введите имя...">
                        <div class="error text-small" id="modal-name-error"></div>
                    </div>
                    <div class="form-input">
                        <label for="phone" class="text-medium">Номер телефона <span
                                style="color: red;">*</span></label>
                        <input id="phone" class="input-transparent" type="tel" name="phone"
                            placeholder="+7 (___)-___-__-__">
                        <div class="error text-small" id="modal-phone-errorr"></div>
                    </div>
                    <div class="form-input">
                        <label for="city" class="text-medium">Город</label>
                        <input id="city" class="input-transparent" type="text" name="city"
                            placeholder="Введите город...">
                    </div>
                </div>
                <div class="form__buttons">
                    <button type="submit" class="button-red-arrow">
                        <span class="text">отправить</span>
                        <span class="icon icon-arrow">
                            <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>
                    <div class="form-input">
                        <div class="form__checkbox">
                            <input type="checkbox" name="policy" id="modal-policy">
                            <label class="text-small" for="modal-policy">Принимаю условия обработки персональных
                                данных</label>
                        </div>
                        <div class="error text-small" id="modal-policy-error"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
