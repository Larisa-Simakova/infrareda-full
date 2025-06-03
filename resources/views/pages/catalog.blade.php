@extends('template.app')
@section('page')
    <section class="catalog">
        <div class="container">
            <p class="text-small"><a href="{{ route('view.main') }}">Главная</a> — <span>Каталог</span></p>
            <h2>Каталог</h2>

            <div class="catalog__items" id="sortable-products">
                @forelse ($products as $product)
                    <div class="catalog__item" data-product-id="{{ $product->id }}">
                        <div class="catalog__item__content">
                            <div class="catalog__item__description">
                                <p class="text-main">{{ $product->title }}</p>
                                <div class="text-medium">{!! $product->short_description !!}</div>
                            </div>
                            <div class="catalog__item__buttons">
                                <a href="{{ route('view.product', $product->id) }}" class="button-red-arrow">
                                    <span class="text">подробнее</span>
                                    <span class="icon icon-arrow">
                                        <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6.81708H17.1287" stroke="white" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="white"
                                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="catalog__item__img">
                            <img src="{{ secure_asset('storage/' . $product->images->first()->url) }}" alt="">
                        </div>
                    </div>
                @empty
                    <p class="text-small">Нет товаров</p>
                @endforelse
            </div>
        </div>
    </section>

    @auth
        @if (auth()->user()->role === 'admin')
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sortable = new Sortable(document.getElementById('sortable-products'), {
                        animation: 150,
                        handle: '.catalog__item',
                        ghostClass: 'sortable-ghost',
                        onEnd: function() {
                            const productItems = document.querySelectorAll('.catalog__item');
                            const order = Array.from(productItems).map((item, index) => ({
                                id: item.dataset.productId,
                                position: index + 1
                            }));

                            fetch('{{ route('admin.products.update-order') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        order: order
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        showNotification('Порядок товаров успешно обновлен', 'success');
                                    } else {
                                        showNotification('Ошибка сохранения порядка', 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    showNotification('Ошибка сохранения порядка', 'error');
                                });
                        }
                    });
                });
            </script>

            <style>
                .sortable-ghost {
                    opacity: 0.5;
                    background: #f8f9fa;
                    border: 2px dashed #dee2e6;
                }

                #sortable-products .catalog__item {
                    cursor: move;
                }
            </style>
        @endif
    @endauth
@endsection
