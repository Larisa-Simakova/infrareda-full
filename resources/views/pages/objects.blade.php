@extends('template.app')

@section('page')
    <section class="objects__page">
        <div class="container">
            <!-- Хлебные крошки -->
            <p class="text-small">
                <a href="{{ route('view.main') }}">Главная</a> — <span>Объекты</span>
            </p>

            <!-- Заголовок -->
            <h2>Выполненные нами объекты</h2>

            <!-- Форма фильтрации -->
            <form id="filterForm" method="GET" action="{{ route('view.objects') }}">
                <select class="js-choice" id="productFilter" name="product_id" onchange="this.form.submit()">
                    <option value="all" {{ request('product_id') == 'all' || !request('product_id') ? 'selected' : '' }}>
                        Все</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->title }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Список объектов -->
            <div class="objects__items" id="objectsContainer">
                @forelse ($objects as $object)
                    <div class="objects__item">
                        <!-- Изображение объекта -->
                        <div class="objects__img">
                            @if ($object->images->first())
                                <img src="{{ asset('storage/' . $object->images->first()->url) }}"
                                    alt="{{ $object->title }}">
                            @else
                                <img src="{{ asset('images/default-project.jpg') }}" alt="Изображение отсутствует">
                            @endif

                            <!-- Местоположение -->
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

                        <!-- Описание объекта -->
                        <div class="objects__content">
                            <div class="objects__description">
                                <p class="text-main">{{ $object->title }}</p>
                            </div>
                            <div class="objects__button">
                                <a href="{{ route('view.object', $object->id) }}" class="button-transparent-arrow">
                                    <span class="text">подробнее</span>
                                    <span class="icon icon-arrow">
                                        <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6.81714H17.1287" stroke="#DC3545" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
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
                @empty
                    <!-- Сообщение, если объектов нет -->
                    <div class="no-objects">
                        <p class="text-small">Нет объектов для выбранной системы отопления</p>
                    </div>
                @endforelse
            </div>

            <!-- Встроенная пагинация с сохранением фильтра -->
            @if ($objects->total() > 0)
                <div class="pagination">
                    @if ($objects->onFirstPage())
                        <span class="pagination-arrow disabled"><</span>
                            @else
                                <a href="{{ $objects->appends(request()->except('page'))->previousPageUrl() }}"
                                    class="pagination-arrow"><</a>
                    @endif

                    @foreach ($objects->getUrlRange(1, $objects->lastPage()) as $page => $url)
                        @if ($page == $objects->currentPage())
                            <span class="current-page">{{ $page }}</span>
                        @else
                            <a
                                href="{{ $objects->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($objects->hasMorePages())
                        <a href="{{ $objects->appends(request()->except('page'))->nextPageUrl() }}"
                            class="pagination-arrow">></a>
                    @else
                        <span class="pagination-arrow disabled">></span>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
