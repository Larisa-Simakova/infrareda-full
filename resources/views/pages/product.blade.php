@extends('template.app')
@section('page')
    <section class="product">
        <div class="container">
            <p class="text-small"><a href="{{ route('view.main') }}">Главная</a> — <a
                    href="{{ route('view.catalog') }}">Каталог</a> —
                <span>{{ $product->title }}</span>
            </p>
            <h2>{{ $product->title }}</h2>
            <div class="product__container">
                <div class="product__content">
                    <div class="text-small">{!! $product->short_description !!}</div>
                    <div class="product__specifications">
                        <p class="text-medium">ПРИМЕНЕНИЕ</p>
                        @forelse ($product->usages as $usage)
                            <div class="product__specification">
                                <svg width="13" height="11" viewBox="0 0 13 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.3915 11H2.60849C1.03762 11 0.0799387 9.2721 0.912499 7.94L4.804 1.71359C5.58734 0.460258 7.41266 0.460258 8.196 1.71359L12.0875 7.94C12.9201 9.2721 11.9624 11 10.3915 11Z"
                                        fill="#DC3545" />
                                </svg>
                                <p class="text-small">{{ $usage->title }}</p>
                            </div>
                        @empty
                        @endforelse
                    </div>

                    <div class="products__buttons">
                        <a href="{{ secure_asset('assets/Опросный лист для подбора ТПИ-28.docx') }}" target="_blank"
                            class="button-transparent-arrow">
                            <span class="text">опросный лист</span>
                            <span class="icon icon-survey">
                                <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.7553 8.52917C19.2053 8.82626 20.614 10.5992 20.614 14.4804V14.605C20.614 18.8888 18.8986 20.6042 14.6149 20.6042H8.37612C4.09237 20.6042 2.37695 18.8888 2.37695 14.605V14.4804C2.37695 10.6279 3.76654 8.85501 7.15904 8.53876"
                                        stroke="#DC3545" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M11.5 1.91663V14.26" stroke="#DC3545" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M14.7099 12.1229L11.4995 15.3333L8.28906 12.1229" stroke="#DC3545"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>
                        <a href="{{ secure_asset('assets/Техническая документация ТПИ-28.pdf') }}" target="_blank"
                            class="button-transparent-arrow">
                            <span class="text">техническая документация</span>
                            <span class="icon icon-survey">
                                <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.7553 8.52917C19.2053 8.82626 20.614 10.5992 20.614 14.4804V14.605C20.614 18.8888 18.8986 20.6042 14.6149 20.6042H8.37612C4.09237 20.6042 2.37695 18.8888 2.37695 14.605V14.4804C2.37695 10.6279 3.76654 8.85501 7.15904 8.53876"
                                        stroke="#DC3545" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M11.5 1.91663V14.26" stroke="#DC3545" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M14.7099 12.1229L11.4995 15.3333L8.28906 12.1229" stroke="#DC3545"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>
                        <button class="button-red-arrow">
                            <span class="text">оставить заявку</span>
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
                    </div>
                </div>
                <div class="product__img">
                    <div class="swiper-container-img">
                        <div class="swiper-wrapper">
                            @foreach ($product->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ secure_asset('storage/' . $image->url) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="custom-pagination"></div>
                    </div>
                </div>
            </div>
            <div class="tabs">
                <div class="tabs__controls">
                    @php
                        $hasAdvantages = !empty($product->advantages) && $product->advantages->count() > 0;
                        $hasModifications = !empty($product->modifications) && $product->modifications->count() > 0;
                        $hasCertificates = !empty($product->certificates) && $product->certificates->count() > 0;
                        $hasFaqs = !empty($product->faqs) && $product->faqs->count() > 0;
                    @endphp
                    <button class="button-red tab">описание</button>
                    @if ($hasAdvantages)
                        <button class="button-transparent tab" data-tab="advantages">преимущества</button>
                    @endif

                    @if ($hasModifications)
                        <button class="button-transparent tab" data-tab="characteristics">характеристики</button>
                    @endif

                    @if ($hasCertificates)
                        <button class="button-transparent tab" data-tab="certificates">сертификаты</button>
                    @endif

                    @if ($hasFaqs)
                        <button class="button-transparent tab" data-tab="faqs">часто задаваемые вопросы</button>
                    @endif
                </div>

                <div class="tabs__content">
                    <div class="tabs__panel description is-active">
                        <div class="product__description">
                            <p class="text-main">Описание</p>
                            <div class="text-small">
                                {!! $product->description !!}
                            </div>
                        </div>
                        <div class="consultation">
                            <p class="text-main">Нужна консультация?</p>
                            <p class="text-small">Оставьте свои данные — позвоним, чтобы обсудить детали
                            </p>
                            <form id="contactForm" method="POST" action="{{ route('send.contact') }}">
                                @csrf
                                <div id="form-error" class="error text-small"
                                    style="display: none; margin-bottom: 15px;"></div>
                                <div class="form__inputs">
                                    <div class="form-input">
                                        <label for="name" class="text-medium">Ваше имя <span
                                                style="color: red;">*</span></label>
                                        <input id="name" class="input-transparent" type="text" name="name"
                                            placeholder="Введите имя...">
                                        <div class="error text-small" id="name-error"></div>
                                    </div>
                                    <div class="form-input">
                                        <label for="phone" class="text-medium">Номер телефона <span
                                                style="color: red;">*</span></label>
                                        <input id="phone" class="input-transparent" type="tel" name="phone"
                                            placeholder="+7 (___)-___-__-__">
                                        <div class="error text-small" id="phone-error"></div>
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
                                                <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5"
                                                    stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white"
                                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="form-input">
                                        <div class="form__checkbox">
                                            <input type="checkbox" name="policy" id="policy">
                                            <label class="text-small" for="policy">Принимаю условия обработки
                                                персональных
                                                данных</label>
                                        </div>
                                        <div class="error text-small" id="policy-error"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="company__form">
                            <h2>Нужна консультация?</h2>
                            <p class="text-main">
                                Оставьте свои данные — позвоним, чтобы обсудить детали
                            </p>
                            <form id="contactForm" method="POST" action="{{ route('send.contact') }}">
                                @csrf
                                <div id="form-error" class="error text-small"
                                    style="display: none; margin-bottom: 15px;"></div>
                                <div class="form__inputs">
                                    <div class="form-input">
                                        <label for="name" class="text-medium">Ваше имя <span
                                                style="color: red;">*</span></label>
                                        <input id="name" class="input-transparent" type="text" name="name"
                                            placeholder="Введите имя...">
                                        <div class="error text-small" id="name-error"></div>
                                    </div>
                                    <div class="form-input">
                                        <label for="phone" class="text-medium">Номер телефона <span
                                                style="color: red;">*</span></label>
                                        <input id="phone" class="input-transparent" type="tel" name="phone"
                                            placeholder="+7 (___)-___-__-__">
                                        <div class="error text-small" id="phone-error"></div>
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
                                                <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5"
                                                    stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white"
                                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="form-input">
                                        <div class="form__checkbox">
                                            <input type="checkbox" name="policy" id="policy">
                                            <label class="text-small" for="policy">Принимаю условия обработки
                                                персональных
                                                данных</label>
                                        </div>
                                        <div class="error text-small" id="policy-error"></div>
                                    </div>
                                </div>
                            </form>
                            <img class="form-fon" src="{{ secure_asset('./assets/images/main/form-fon.png') }}" alt="">
                        </div>
                    </div>
                    @if ($hasAdvantages)
                        <div class="tabs__panel">
                            <div class="products__advantages" id="sortable-advantages">
                                @foreach ($product->advantages as $advantage)
                                    <div class="products__advantage" data-advantage-id="{{ $advantage->id }}">
                                        <div class="advantage__title">
                                            <img src="{{ secure_asset('storage/' . $advantage->img) }}" alt="">
                                            <p class="text-main">{{ $advantage->title }}</p>
                                        </div>
                                        <div class="advantage__content">
                                            <div class="advantage__description">
                                                {!! $advantage->description !!}
                                            </div>
                                            <div class="advantage__comparison">
                                                <div class="advantage__compare">
                                                    <p class="text-medium">Инфракрасная система отопления</p>
                                                    {!! $advantage->infrared_description !!}
                                                </div>
                                                <div class="advantage__compare">
                                                    <p class="text-medium">Традиционное отопление</p>
                                                    {!! $advantage->traditional_description !!}
                                                </div>
                                            </div>
                                        </div>
                                        @auth
                                            @if (auth()->user()->role === 'admin')
                                                <div class="advantage-admin-controls">
                                                    <span class="drag-handle">≡</span>
                                                    <a href="{{ route('admin.products.edit', ['product' => $product->id, 'step' => 'advantages']) }}"
                                                        class="edit-btn">✎</a>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif


                    @if ($hasModifications)
                        <div class="tabs__panel">
                            <div class="specs-slider-container">
                                <input type="range" min="0" max="100" value="0" class="specs-slider"
                                    id="specsSlider">
                                <div class="custom-thumb" id="customThumb">
                                    <svg width="20" height="20" viewBox="0 0 35 35" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M28.1304 13.373L11.2283 4.47714C7.2179 2.36256 2.85749 6.63547 4.88457 10.6896L7.24707 15.4146C7.90332 16.7271 7.90332 18.273 7.24707 19.5855L4.88457 24.3105C2.85749 28.3646 7.2179 32.623 11.2283 30.523L28.1304 21.6271C31.4554 19.8771 31.4554 15.123 28.1304 13.373Z"
                                            fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>

                            <div class="specs-container">
                                <div class="specs-sidebar">
                                    <div class="specs-title">
                                        <p class="text-main">Характеристики</p>
                                    </div>

                                    @php
                                        // Получаем все уникальные характеристики для всех модификаций
                                        $allCharacteristics = $product->modifications
                                            ->flatMap(function ($mod) {
                                                return $mod->characteristics;
                                            })
                                            ->unique('id');
                                    @endphp

                                    <ul class="specs-list" id="specsList">
                                        @foreach ($allCharacteristics as $characteristic)
                                            <li class="specs-item">{{ $characteristic->title }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="specs-content">
                                    <div class="specs-scrollable" id="scrollableContent">
                                        @foreach ($product->modifications as $modification)
                                            <div class="specs-column">
                                                <div class="specs-title">
                                                    <p class="text-main">{{ $modification->title }}</p>
                                                </div>

                                                <div class="specs-values">
                                                    @foreach ($allCharacteristics as $characteristic)
                                                        @php
                                                            // Находим значение для текущей характеристики в текущей модификации
                                                            $value =
                                                                $modification->modificationCharacteristics
                                                                    ->where('characteristic_id', $characteristic->id)
                                                                    ->first()->value ?? '-';
                                                        @endphp
                                                        <div class="specs-value">{{ $value }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($hasCertificates)
                        <div class="tabs__panel sertificates">
                            <div class="update-images">
                                @foreach ($product->certificates as $certificate)
                                    @php
                                        $isPdf = pathinfo($certificate->url, PATHINFO_EXTENSION) === 'pdf';
                                        $previewPath = $isPdf
                                            ? str_replace('.pdf', '_preview.jpg', $certificate->url)
                                            : $certificate->url;
                                    @endphp

                                    <div class="image-block">
                                        <a href="{{ secure_asset('storage/' . $certificate->url) }}" target="_blank">
                                            @if ($isPdf)
                                                @if (Storage::disk('public')->exists($previewPath))
                                                    <img src="{{ secure_asset('storage/' . $previewPath) }}" alt="PDF preview">
                                                @else
                                                    <svg viewBox="0 0 24 24" width="48" height="48">
                                                        <path fill="#FF0000"
                                                            d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                                        <path fill="#000000"
                                                            d="M10,12A2,2 0 0,0 8,14V16A2,2 0 0,0 10,18H11V21H13V18H14A2,2 0 0,0 16,16V14A2,2 0 0,0 14,12H10M10,14H14V16H10V14Z" />
                                                    </svg>
                                                @endif
                                            @else
                                                <img src="{{ secure_asset('storage/' . $certificate->url) }}"
                                                    alt="Превью сертификата">
                                            @endif
                                        </a>
                                        <a class="button-red download-button"
                                            href="{{ secure_asset('storage/' . $certificate->url) }}" target="_blank" download>
                                            Скачать
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($hasFaqs)
                        <div class="tabs__panel faq">
                            <div class="accordion-items">
                                @foreach ($product->faqs as $faq)
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <p class="text-main">{{ $faq->question }}</p>
                                            <div class="button-transparent-arrow">
                                                <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 6.81714H17.1287" stroke="#DC3545" stroke-width="1.5"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M11.4727 1L17.2897 6.81708L11.4727 12.6342" stroke="#DC3545"
                                                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="accordion-content">
                                            <div class="text-small">{!! $faq->answer !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="consultation">
                                <p class="text-main">Нужна консультация?</p>
                                <p class="text-small">Оставьте свои данные — позвоним, чтобы обсудить детали
                                </p>
                                <form id="contactForm" method="POST" action="{{ route('send.contact') }}">
                                    @csrf
                                    <div id="form-error" class="error text-small"
                                        style="display: none; margin-bottom: 15px;"></div>
                                    <div class="form__inputs">
                                        <div class="form-input">
                                            <label for="name" class="text-medium">Ваше имя <span
                                                    style="color: red;">*</span></label>
                                            <input id="name" class="input-transparent" type="text"
                                                name="name" placeholder="Введите имя...">
                                            <div class="error text-small" id="name-error"></div>
                                        </div>
                                        <div class="form-input">
                                            <label for="phone" class="text-medium">Номер телефона <span
                                                    style="color: red;">*</span></label>
                                            <input id="phone" class="input-transparent" type="tel"
                                                name="phone" placeholder="+7 (___)-___-__-__">
                                            <div class="error text-small" id="phone-error"></div>
                                        </div>
                                        <div class="form-input">
                                            <label for="city" class="text-medium">Город</label>
                                            <input id="city" class="input-transparent" type="text"
                                                name="city" placeholder="Введите город...">
                                        </div>
                                    </div>
                                    <div class="form__buttons">
                                        <button type="submit" class="button-red-arrow">
                                            <span class="text">отправить</span>
                                            <span class="icon icon-arrow">
                                                <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white"
                                                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </button>
                                        <div class="form-input">
                                            <div class="form__checkbox">
                                                <input type="checkbox" name="policy" id="policy">
                                                <label class="text-small" for="policy">Принимаю условия обработки
                                                    персональных
                                                    данных</label>
                                            </div>
                                            <div class="error text-small" id="policy-error"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="company__form">
                                <h2>Нужна консультация?</h2>
                                <p class="text-main">
                                    Оставьте свои данные — позвоним, чтобы обсудить детали
                                </p>
                                <form id="contactForm" method="POST" action="{{ route('send.contact') }}">
                                    @csrf
                                    <div id="form-error" class="error text-small"
                                        style="display: none; margin-bottom: 15px;"></div>
                                    <div class="form__inputs">
                                        <div class="form-input">
                                            <label for="name" class="text-medium">Ваше имя <span
                                                    style="color: red;">*</span></label>
                                            <input id="name" class="input-transparent" type="text"
                                                name="name" placeholder="Введите имя...">
                                            <div class="error text-small" id="name-error"></div>
                                        </div>
                                        <div class="form-input">
                                            <label for="phone" class="text-medium">Номер телефона <span
                                                    style="color: red;">*</span></label>
                                            <input id="phone" class="input-transparent" type="tel"
                                                name="phone" placeholder="+7 (___)-___-__-__">
                                            <div class="error text-small" id="phone-error"></div>
                                        </div>
                                        <div class="form-input">
                                            <label for="city" class="text-medium">Город</label>
                                            <input id="city" class="input-transparent" type="text"
                                                name="city" placeholder="Введите город...">
                                        </div>
                                    </div>
                                    <div class="form__buttons">
                                        <button type="submit" class="button-red-arrow">
                                            <span class="text">отправить</span>
                                            <span class="icon icon-arrow">
                                                <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white"
                                                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </button>
                                        <div class="form-input">
                                            <div class="form__checkbox">
                                                <input type="checkbox" name="policy" id="policy">
                                                <label class="text-small" for="policy">Принимаю условия обработки
                                                    персональных
                                                    данных</label>
                                            </div>
                                            <div class="error text-small" id="policy-error"></div>
                                        </div>
                                    </div>
                                </form>
                                <img class="form-fon" src="{{ secure_asset('./assets/images/main/form-fon.png') }}"
                                    alt="">
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>


    @if ($objects->isNotEmpty())
        <section class="objects container">
            <div class="objects__title">
                <h2>выполненные объекты</h2>
                <div class="objects__action">
                    <a href="{{ route('view.objects') }}" class="button-red-arrow">
                        <span class="text">все проекты</span>
                        <span class="icon icon-arrow">
                            <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @forelse ($objects as $object)
                        <div class="swiper-slide">
                            <div class="objects__item">
                                <div class="objects__img">
                                    <img src="{{ secure_asset('storage/' . $object->images->first()->url) }}" alt="">
                                    <div class="objects__place">
                                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4998 12.8704C13.1511 12.8704 14.4898 11.5317 14.4898 9.88038C14.4898 8.22905 13.1511 6.89038 11.4998 6.89038C9.84843 6.89038 8.50977 8.22905 8.50977 9.88038C8.50977 11.5317 9.84843 12.8704 11.4998 12.8704Z"
                                                stroke="#DC3545" stroke-width="1.3" />
                                            <path
                                                d="M3.46897 8.13621C5.35689 -0.162955 17.6523 -0.153372 19.5306 8.14579C20.6327 13.0141 17.6044 17.135 14.9498 19.6841C13.0236 21.5433 9.97605 21.5433 8.04022 19.6841C5.39522 17.135 2.36689 13.0045 3.46897 8.13621Z"
                                                stroke="#DC3545" stroke-width="1.3" />
                                        </svg>
                                        <p class="text-small">{{ $object->place }}</p>
                                    </div>
                                </div>
                                <div class="objects__content">
                                    <div class="objects__description">
                                        <p class="text-main">{{ $object->title }}</p>
                                    </div>
                                    <div class="objects__button">
                                        <a href="{{ route('view.object', $object->id) }}"
                                            class="button-transparent-arrow">
                                            <span class="text">подробнее</span>
                                            <span class="icon icon-arrow">
                                                <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 6.81714H17.1287" stroke="#DC3545" stroke-width="1.5"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="#DC3545"
                                                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </a>
                                        <p class="text-date">{{ $object->date->format('d.m.Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="swiper-pagination custom-pagination"></div>
            </div>
        </section>
    @endif

    <section class="blogs container">
        <div class="py-140">
            <div class="blogs__title">
                <h2>блог</h2>
                <a href="{{ route('view.blogs') }}" class="button-red-arrow">
                    <span class="text">смотреть всё</span>
                    <span class="icon icon-arrow">
                        <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
            </div>

            <div class="blogs__items">
                <div class="blogs__item">
                    <img src="{{ secure_asset('storage/' . $latestBlog->images->first()->url) }}"
                        alt="{{ $latestBlog->title }}">
                    <div class="blogs__content">
                        <div class="blogs__description">
                            <p class="text-main">{{ $latestBlog->title }}</p>
                            <div class="text-small">
                                {{ strtok(strip_tags(html_entity_decode($latestBlog->description)), '.') }}
                            </div>
                        </div>
                        <div class="blogs__button">
                            <a class="link-red text-small link-more" href="{{ route('view.blog', $latestBlog->id) }}">
                                Читать полностью
                            </a>
                            <p class="text-date">{{ $latestBlog->date->format('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Блок последних новостей -->
                <div class="blogs__news-wrapper">
                    <div class="blogs__news">
                        @foreach ($recentBlogs as $blog)
                            <div class="blogs__new">
                                <div class="blogs__new-text">
                                    <p class="text-date">{{ $blog->date->format('d.m.Y') }}</p>
                                    <p class="text-main">{{ $blog->title }}</p>
                                </div>
                                <a href="{{ route('view.blog', $blog->id) }}" class="button-transparent-arrow">
                                    <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6.81714H17.1287" stroke="#DC3545" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.4727 1L17.2897 6.81708L11.4727 12.6342" stroke="#DC3545"
                                            stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </section>

    <div id="productRequestModal" class="modal">
        <div class="modal-content">
            <button class="modal__close">&times;</button>
            <h2>Оставить заявку на товар</h2>
            <form id="productRequestForm" class="modal__form">
                @csrf
                <input type="hidden" id="productName" name="product_name">
                <div class="form__inputs">
                    <div class="form-input">
                        <label for="product-request-name" class="text-medium">Ваше имя <span
                                style="color: red;">*</span></label>
                        <input id="product-request-name" class="input-transparent" type="text" name="name"
                            placeholder="Введите имя...">
                        <div class="error text-small" id="product-request-name-error"></div>
                    </div>
                    <div class="form-input">
                        <label for="product-request-phone" class="text-medium">Номер телефона <span
                                style="color: red;">*</span></label>
                        <input id="product-request-phone" class="input-transparent" type="tel" name="phone"
                            placeholder="+7 (___)-___-__-__">
                        <div class="error text-small" id="product-request-phone-error"></div>
                    </div>
                    <div class="form-input">
                        <label for="product-request-city" class="text-medium">Город</label>
                        <input id="product-request-city" class="input-transparent" type="text" name="city"
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
                            <input type="checkbox" name="policy" id="product-request-policy">
                            <label class="text-small" for="product-request-policy">Принимаю условия обработки персональных
                                данных</label>
                        </div>
                        <div class="error text-small" id="product-request-policy-error"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // === Tabs Class ===
            class Tabs {
                constructor(container) {
                    this.tabs = container;
                    this.buttons = this.tabs.querySelectorAll('.tab');
                    this.panels = this.tabs.querySelectorAll('.tabs__panel');
                    this.init();
                }

                init() {
                    this.buttons.forEach((btn, index) => {
                        btn.addEventListener('click', () => this.activateTab(index));
                    });
                }

                activateTab(index) {
                    this.buttons.forEach(btn => {
                        btn.classList.remove('button-red');
                        btn.classList.add('button-transparent');
                    });
                    this.buttons[index].classList.add('button-red');
                    this.buttons[index].classList.remove('button-transparent');
                    this.panels.forEach(panel => panel.classList.remove('is-active'));
                    this.panels[index].classList.add('is-active');

                    // Вызов функции только при открытии вкладки "Преимущества"
                    if (this.buttons[index].dataset.tab === 'advantages') {
                        setTimeout(equalizeComparisonHeights, 100);
                    }
                }
            }

            document.querySelectorAll('.tabs').forEach(tabs => new Tabs(tabs));

            // === Slider for Characteristics ===
            const slider = document.getElementById('specsSlider');
            const scrollable = document.getElementById('scrollableContent');
            const customThumb = document.getElementById('customThumb');
            let isDragging = false;
            let maxScroll = scrollable ? scrollable.scrollWidth - scrollable.clientWidth : 0;

            function updateSlider() {
                if (isDragging) return;
                maxScroll = scrollable ? scrollable.scrollWidth - scrollable.clientWidth : 0;
                const scrollPercent = maxScroll > 0 ? (scrollable.scrollLeft / maxScroll) * 100 : 0;
                if (slider) slider.value = scrollPercent;
                if (customThumb) updateThumbPosition(scrollPercent);
            }

            function updateThumbPosition(percent) {
                const sliderWidth = slider?.offsetWidth || 0;
                const thumbWidth = customThumb?.offsetWidth || 0;
                const thumbPosition = (percent / 100) * (sliderWidth - thumbWidth);
                if (customThumb) customThumb.style.left = `${thumbPosition}px`;
                if (slider) slider.style.setProperty('--progress', `${percent}%`);
            }

            if (slider) {
                slider.addEventListener('input', function() {
                    if (!isDragging) isDragging = true;
                    const percent = this.value;
                    if (scrollable) scrollable.scrollLeft = (percent / 100) * maxScroll;
                    updateThumbPosition(percent);
                });
                slider.addEventListener('change', function() {
                    isDragging = false;
                });
            }

            if (scrollable) {
                scrollable.addEventListener('scroll', function() {
                    if (!isDragging) requestAnimationFrame(updateSlider);
                });
            }

            function handleResize() {
                if (scrollable) {
                    maxScroll = scrollable.scrollWidth - scrollable.clientWidth;
                }
                updateSlider();
                syncHeights();
            }

            const resizeObserver = new ResizeObserver(handleResize);
            if (scrollable) resizeObserver.observe(scrollable);
            resizeObserver.observe(document.body);

            function syncHeights() {
                const specsItems = document.querySelectorAll('#specsList .specs-item');
                const specsColumns = document.querySelectorAll('.specs-column');
                specsColumns.forEach(column => {
                    const values = column.querySelectorAll('.specs-value');
                    values.forEach((value, index) => {
                        if (specsItems[index]) {
                            value.style.minHeight = `${specsItems[index].offsetHeight}px`;
                        }
                    });
                });
            }

            updateSlider();
            syncHeights();

            // === equalizeComparisonHeights Function ===
            function forceReflow(element) {
                void element?.offsetHeight;
            }

            function equalizeComparisonHeights() {
                const container = document.querySelector('.products__advantages');
                if (!container) return;

                forceReflow(container); // Принудительная перерисовка

                const comparisons = container.querySelectorAll('.advantage__comparison');
                if (comparisons.length <= 1) {
                    // Если одна или ноль карточек — ничего не делаем
                    comparisons.forEach(comparison => {
                        comparison.style.height = 'auto'; // Убираем фиксированную высоту
                    });
                    return;
                }

                let maxHeight = 0;

                comparisons.forEach(comparison => {
                    comparison.style.height = 'auto';
                });

                const images = container.querySelectorAll('img');
                let imagesLoaded = 0;

                function checkImagesLoaded() {
                    if (imagesLoaded === images.length) {
                        comparisons.forEach(comparison => {
                            const height = comparison.offsetHeight;
                            if (height > maxHeight) maxHeight = height;
                        });
                        comparisons.forEach(comparison => {
                            comparison.style.height = `${maxHeight}px`;
                        });
                    }
                }

                if (images.length === 0) {
                    // Нет изображений — можно сразу считать высоту
                    comparisons.forEach(comparison => {
                        const height = comparison.offsetHeight;
                        if (height > maxHeight) maxHeight = height;
                    });
                    comparisons.forEach(comparison => {
                        comparison.style.height = `${maxHeight}px`;
                    });
                    return;
                }

                images.forEach(img => {
                    if (img.complete) {
                        imagesLoaded++;
                        checkImagesLoaded();
                    } else {
                        img.addEventListener('load', () => {
                            imagesLoaded++;
                            checkImagesLoaded();
                        });
                    }
                });
            }

            // Первичный запуск после загрузки страницы
            window.addEventListener('load', function() {
                setTimeout(equalizeComparisonHeights, 300);
            });

            // Также на ресайз
            window.addEventListener('resize', equalizeComparisonHeights);
        });
    </script>

    @auth
        @if (auth()->user()->role === 'admin')
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Инициализация сортировки преимуществ
                    const sortableAdvantages = new Sortable(document.getElementById('sortable-advantages'), {
                        animation: 150,
                        handle: '.drag-handle',
                        ghostClass: 'sortable-ghost',
                        onEnd: function() {
                            updateAdvantagesOrder();
                        }
                    });

                    // Функция обновления порядка преимуществ
                    function updateAdvantagesOrder() {
                        const advantageItems = document.querySelectorAll('#sortable-advantages .products__advantage');
                        const order = Array.from(advantageItems).map((item, index) => ({
                            id: item.dataset.advantageId,
                            position: index + 1
                        }));

                        fetch('{{ route('admin.products.advantages.order', $product->id) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json' // Явно указываем, что ожидаем JSON
                                },
                                body: JSON.stringify({
                                    order: order
                                }),
                                credentials: 'same-origin'
                            })
                            .then(async response => {
                                // Проверяем Content-Type ответа
                                const contentType = response.headers.get('content-type');
                                if (!contentType || !contentType.includes('application/json')) {
                                    const text = await response.text();
                                    throw new Error(`Ожидался JSON, но получен: ${text.substring(0, 100)}...`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data && data.success) {
                                    showNotification('Порядок преимуществ успешно обновлён', 'success');
                                } else {
                                    throw new Error(data.message || 'Неизвестная ошибка сервера');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('Ошибка сохранения порядка: ' + error.message, 'error');
                                // Восстановление исходного порядка при ошибке
                                sortableAdvantages.sort(Array.from(advantageItems).map(item => item.dataset
                                    .advantageId));
                            });
                    }
                });
            </script>

            <style>
                .sortable-ghost {
                    opacity: 0.5;
                    background: #f8f9fa;
                    border: 2px dashed #dee2e6;
                }

                .products__advantage {
                    position: relative;
                }

                .drag-handle {
                    position: absolute;
                    top: 10px;
                    right: 40px;
                    cursor: move;
                    font-size: 20px;
                    color: #dc3545;
                }

                .edit-btn {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    cursor: pointer;
                    font-size: 20px;
                    color: #dc3545;
                    text-decoration: none;
                }

                .advantage-admin-controls {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                }
            </style>
        @endif
    @endauth
@endsection
