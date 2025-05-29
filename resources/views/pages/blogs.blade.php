@extends('template.app')
@section('page')
    <section class="objects__page">
        <div class="container">
            <p class="text-small"><a href="{{ route('view.main') }}">Главная</a> — <span>Блог</span></p>
            <h2>Блог</h2>
            <div class="objects__items">
                @forelse ($blogs as $blog)
                    <div class="blogs__item">
                        <img src="{{ secure_asset('storage/' . $blog->images->first()->url) }}" alt="">
                        <div class="blogs__content">
                            <p class="text-main">{{ $blog->title }}</p>
                            <div class="blogs__button">
                                <a href="{{ route('view.blog', $blog->id) }}" class="button-transparent-arrow">
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
                                <p class="text-date">{{ $blog->date->format('d.m.Y') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-small">Нет новостей</p>
                @endforelse
            </div>

            <!-- Пагинация -->
            @if ($blogs->hasPages())
                <div class="pagination">
                    @if ($blogs->currentPage() > 1)
                        <a href="{{ $blogs->previousPageUrl() }}" class="pagination-arrow">‹</a>
                    @else
                        <span class="pagination-arrow disabled">‹</span>
                    @endif

                    @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="{{ $page == $blogs->currentPage() ? 'current-page' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($blogs->hasMorePages())
                        <a href="{{ $blogs->nextPageUrl() }}" class="pagination-arrow">›</a>
                    @else
                        <span class="pagination-arrow disabled">›</span>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
