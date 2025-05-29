@extends('template.app')
@section('page')
    <section class="admin">
        <div class="container">
            <div class="admin-actions">
                <div class="admin-buttons">
                    <a href="{{ route('view.admin') }}" class="button-transparent">Товары</a>
                    <a href="{{ route('view.admin.objects') }}" class="button-transparent">Объекты</a>
                    <a href="{{ route('view.admin.blogs') }}" class="button-red">Блог</a>
                </div>
                <a href="{{ route('view.blog.create') }}" class="button-red-arrow">
                    <span class="text">добавить новость</span>
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
            <div class="objects__items">
                @forelse ($blogs as $blog)
                    <div class="blogs__item" data-blog-id="{{ $blog->id }}">
                        @if ($blog->images->isNotEmpty())
                            <img src="{{ secure_asset('storage/' . $blog->images->first()->url) }}" alt="">
                        @endif
                        <div class="blogs__content">
                            <p class="text-main">{{ $blog->title }}</p>
                            <div class="blogs__button">
                                <div class="actions__button">
                                    <a href="{{ route('view.blog.update', $blog->id) }}" class="button-transparent-arrow">
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
                                <p class="text-date">{{ $blog->date->format('d.m.Y') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-medium">Нет новостей</p>
                @endforelse
            </div>
            @if ($blogs->hasPages())
                <div class="pagination">
                    @if ($blogs->onFirstPage())
                        <span class="pagination-arrow disabled"><</span>
                            @else
                                <a href="{{ $blogs->appends(request()->except('page'))->previousPageUrl() }}"
                                    class="pagination-arrow"><</a>
                    @endif

                    @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                        @if ($page == $blogs->currentPage())
                            <span class="current-page">{{ $page }}</span>
                        @else
                            <a href="{{ $blogs->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($blogs->hasMorePages())
                        <a href="{{ $blogs->appends(request()->except('page'))->nextPageUrl() }}"
                            class="pagination-arrow">></a>
                    @else
                        <span class="pagination-arrow disabled">></span>
                    @endif
                </div>
            @endif
        </div>
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <p class="text-main" id="modalTitle">Вы действительно хотите удалить новость "<span id="blogTitle"></span>"?
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
            const deleteButtons = document.querySelectorAll('.blogs__button .button-transparent');
            const modal = document.getElementById('deleteModal');
            const blogTitleSpan = document.getElementById('blogTitle');
            const confirmBtn = document.getElementById('confirmDelete');
            const cancelBtn = document.getElementById('cancelDelete');

            let currentBlogId = null;
            let currentBlogTitle = null;

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
                    currentBlogId = null;
                    currentBlogTitle = null;
                }, 300);
            }

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const blogItem = this.closest('.blogs__item');
                    currentBlogTitle = blogItem.querySelector('.text-main').textContent;
                    currentBlogId = blogItem.dataset.blogId;

                    blogTitleSpan.textContent = currentBlogTitle;
                    openModal();
                });
            });

            confirmBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentBlogId) {
                    fetch(`/blogs/${currentBlogId}/delete`, {
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
                                showNotification('Новость успешно удалена', 'success');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        })
                        .catch(error => {
                            console.error('Ошибка:', error);
                            alert('Не удалось удалить новость');
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
