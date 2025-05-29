@extends('template.app')
@section('page')
    <section class="blog">
        <div class="container">
            <p class="text-small"><a href="{{ route('view.main') }}">Главная</a> — <a href="{{ route('view.blogs') }}">Блог</a>
                — <span>{{ $blog->title }}</span></p>
            <h2>{{ $blog->title }}</h2>
            <div class="blog__container">
                <div class="blog__content">
                    <div class="blog__img">
                        <div class="swiper-container-img">
                            <div class="swiper-wrapper">
                                @foreach ($blog->images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ secure_asset('storage/' . $image->url) }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                            <div class="custom-pagination"></div>
                        </div>
                    </div>
                    <div class="text-medium">{!! $blog->description !!}</div>
                    <p class="text-date">{{ $blog->date->format('d.m.Y') }}</p>
                </div>
            </div>
            <div class="blogs__similar">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($blogs as $blog)
                            <div class="swiper-slide">
                                <div class="blogs__item">
                                    <img src="{{ secure_asset('storage/' . $blog->images->first()->url) }}">
                                    <div class="blogs__content">
                                        <p class="text-main">{{ $blog->title }}</p>
                                        <div class="blogs__button">
                                            <a href="{{ route('view.blog', $blog->id) }}" class="button-transparent-arrow">
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
                                            <p class="text-date">{{ $blog->date->format('d.m.Y') }}</p>
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
