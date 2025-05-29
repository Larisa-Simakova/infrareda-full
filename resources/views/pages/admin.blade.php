@extends('template.app')
@section('page')
    <section class="admin">
        <div class="container">
            <div class="admin-actions">
                <div class="admin-buttons">
                    <a href="{{ route('view.admin') }}" class="button-red">Товары</a>
                    <a href="{{ route('view.admin.objects') }}" class="button-transparent">Объекты</a>
                    <a href="{{ route('view.admin.blogs') }}" class="button-transparent">Блог</a>
                </div>
                <a href="{{ route('admin.products.create') }}" class="button-red-arrow">
                    <span class="text">добавить товар</span>
                    <span class="icon icon-arrow">
                        <svg width="19" height="14" viewBox="0 0 19 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 6.81714H17.1287" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M11.4746 1L17.2917 6.81708L11.4746 12.6342" stroke="#fff" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
            </div>
            <div class="catalog__items">
                @forelse ($products as $product)
                    <div class="catalog__item" data-product-id="{{ $product->id }}">
                        <div class="catalog__item__content">
                            <div class="catalog__item__description">
                                <p class="text-main">{{ $product->title }}</p>

                                <div class="text-small">
                                    {{ strtok(strip_tags(html_entity_decode($product->description)), '.') }}
                                </div>
                            </div>
                            <div class="catalog__item__buttons">
                                <div class="actions__button">
                                    <a href="{{ route('admin.products.edit', ['product' => $product->id, 'step' => 'description']) }}"
                                        class="button-transparent-arrow">
                                        <span class="text">редактировать</span>
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
                                    <button class="button-transparent">удалить</button>
                                </div>
                            </div>
                        </div>
                        <div class="catalog__item__img">
                            <img src="{{ secure_asset('storage/' . $product->images->first()->url) }}" alt="">
                        </div>
                    </div>
                @empty
                    <p class="text-medium">Нет товаров</p>
                @endforelse
            </div>
        </div>
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <p class="text-main" id="modalTitle">Вы действительно хотите удалить товар "<span
                        id="productTitle"></span>"?
                </p>
                <div class="modal-buttons">
                    <button id="confirmDelete" class="button-transparent">Да, удалить</button>
                    <button id="cancelDelete" class="button-red">Отмена</button>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.catalog__item__buttons .button-transparent');
            const modal = document.getElementById('deleteModal');
            const productTitleSpan = document.getElementById('productTitle');
            const confirmBtn = document.getElementById('confirmDelete');
            const cancelBtn = document.getElementById('cancelDelete');

            let currentProductId = null;
            let currentProductTitle = null;

            function openModal() {
                modal.style.display = 'block';
                setTimeout(() => {
                    modal.classList.add('active');
                }, 10);
                document.body.classList.add('modal-open');
            }

            function closeModal() {
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    currentProductId = null;
                    currentProductTitle = null;
                }, 300);
            }

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productItem = this.closest('.catalog__item');
                    currentProductTitle = productItem.querySelector('.text-main').textContent;
                    currentProductId = productItem.dataset.productId;

                    productTitleSpan.textContent = currentProductTitle;
                    openModal();
                });
            });

            confirmBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentProductId) {
                    fetch(`/admin/products/${currentProductId}/delete`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            credentials: 'same-origin'
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Ошибка сети');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showNotification('Товар успешно удален', 'success');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showNotification(data.message || 'Не удалось удалить объект', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Ошибка:', error);
                            alert('Не удалось удалить объект');
                        })
                        .finally(() => {
                            closeModal();
                        });
                }
            });

            cancelBtn.addEventListener('click', closeModal);

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
