@extends('template.app')
@section('page')
    <section class="admin">
        <div class="container">
            <div class="admin-actions">
                <div class="admin-buttons">
                    <a href="{{ route('view.admin') }}" class="button-transparent">Товары</a>
                    <a href="{{ route('view.admin.objects') }}" class="button-red">Объекты</a>
                    <a href="{{ route('view.admin.blogs') }}" class="button-transparent">Блог</a>
                </div>
                <a href="{{ route('view.object.create') }}" class="button-red-arrow">
                    <span class="text">добавить объект</span>
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

            <form id="filterForm" method="GET" action="{{ route('view.admin.objects') }}">
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

            <div class="objects__items" id="objectsContainer">
                @forelse ($objects as $object)
                    <div class="objects__item" data-product-id="{{ $object->product_id }}"
                        data-object-id="{{ $object->id }}">
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
                                <div class="actions__button">
                                    <a href="{{ route('view.object.update', $object->id) }}"
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
                                    <button class="button-transparent delete-btn">удалить</button>
                                </div>
                                <p class="text-date">{{ $object->date->format('d.m.Y') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-small">
                        Нет объектов для выбранной системы отопления
                    </p>
                @endforelse
            </div>

            <!-- Пагинация с сохранением фильтра -->
            @if ($objects->hasPages())
                <div class="pagination">
                    @if ($objects->onFirstPage())
                        <span class="pagination-arrow disabled">
                            << /span>
                            @else
                                <a href="{{ $objects->appends(request()->except('page'))->previousPageUrl() }}"
                                    class="pagination-arrow">
                                    << /a>
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
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <p class="text-main" id="modalTitle">Вы действительно хотите удалить объект "<span
                        id="objectTitle"></span>"?
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
            const productFilter = document.getElementById('productFilter');
            const objectsContainer = document.getElementById('objectsContainer');
            const allObjects = document.querySelectorAll('.objects__item');

            productFilter.addEventListener('change', function() {
                const selectedValue = this.value;

                allObjects.forEach(object => {
                    if (selectedValue === 'all' || object.dataset.productId === selectedValue) {
                        object.style.display = 'block';
                    } else {
                        object.style.display = 'none';
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.objects__button .button-transparent');
            const modal = document.getElementById('deleteModal');
            const objectTitleSpan = document.getElementById('objectTitle');
            const confirmBtn = document.getElementById('confirmDelete');
            const cancelBtn = document.getElementById('cancelDelete');

            let currentObjectId = null;
            let currentObjectTitle = null;

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
                    currentObjectId = null;
                    currentObjectTitle = null;
                }, 300);
            }

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const objectItem = this.closest('.objects__item');
                    currentObjectTitle = objectItem.querySelector('.text-main').textContent;
                    currentObjectId = objectItem.dataset.objectId;

                    objectTitleSpan.textContent = currentObjectTitle;
                    openModal();
                });
            });

            confirmBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentObjectId) {
                    fetch(`/objects/${currentObjectId}/delete`, {
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
                                showNotification('Объект успешно удален', 'success');
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
