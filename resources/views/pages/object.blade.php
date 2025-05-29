@extends('template.app')
@section('page')
    <section class="object">
        <div class="container">
            <p class="text-small"><a href="{{ route('view.main') }}">Главная</a> — <a
                    href="{{ route('view.objects') }}">Объекты</a> — <span>{{ $object->title }}</span></p>
            <h2>{{ $object->title }}</h2>
            <div class="object__container">
                <div class="object__content">
                    <div class="text-medium">{!! $object->description !!}</div>
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
                        <p class="text-main">{{ $object->place }}</p>
                    </div>
                    <div class="object__specifications">
                        <p class="text-medium">характеристики</p>
                        <div class="object__specification">
                            <img src="{{ secure_asset('assets/images/main/objects/square.svg') }}" alt="">
                            <p class="text-small">Площадь: {{ $object->square }} м</p>
                        </div>
                        <div class="object__specification">
                            <img src="{{ secure_asset('assets/images/main/objects/height.svg') }}" alt="">
                            <p class="text-small">Высота: {{ $object->height }} м</p>
                        </div>
                    </div>
                    <p class="text-date">{{ $object->date->format('d.m.Y') }}</p>
                </div>
                <div class="object__img">
                    <div class="swiper-container-img">
                        <div class="swiper-wrapper">
                            @foreach ($object->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ secure_asset('storage/' . $image->url) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="custom-pagination"></div>
                    </div>
                </div>
            </div>
            <div class="objects__similar">
                <h2>Похожие объекты</h2>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($similarObjects as $similarObject)
                            <div class="swiper-slide">
                                <div class="objects__item">
                                    <div class="objects__img">
                                        <img src="{{ secure_asset('storage/' . $similarObject->images->first()->url) }}"
                                            alt="{{ $similarObject->title }}">
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
                                            <p class="text-small">{{ $similarObject->place }}</p>
                                        </div>
                                    </div>
                                    <div class="objects__content">
                                        <div class="objects__description">
                                            <p class="text-main">{{ $similarObject->title }}</p>
                                        </div>
                                        <div class="objects__button">
                                            <a href="{{ route('view.object', $similarObject->id) }}"
                                                class="button-transparent-arrow">
                                                <span class="text">подробнее</span>
                                                <span class="icon icon-arrow">
                                                    <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 6.81714H17.1287" stroke="#DC3545" stroke-width="1.5"
                                                            stroke-miterlimit="10" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342"
                                                            stroke="#DC3545" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <p class="text-date">{{ $similarObject->date->format('d.m.Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination custom-pagination"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
