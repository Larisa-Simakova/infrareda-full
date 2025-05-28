@extends('template.app')
@section('page')
    <section class="admin add_product">
        <div class="container">
            <div class="admin-actions">
                <div class="admin-buttons">
                    <a href="{{ route('view.admin') }}" class="button-transparent">Товары</a>
                    <a href="{{ route('view.admin.objects') }}" class="button-transparent">Объекты</a>
                    <a href="{{ route('view.admin.blogs') }}" class="button-transparent">Блог</a>
                </div>
            </div>

            <div class="mobile-menu-toggle d-lg-none">
                <button class="button-transparent" id="sidebarToggle">
                    <i class="fas fa-bars"></i> Меню товара
                </button>
            </div>

            <div class="product-form-container">
                <div class="product-sidebar" id="productSidebar">
                    <ul class="sidebar-menu">
                        <li class="{{ $currentStep === 'description' ? 'active' : '' }} text-small">
                            <a href="{{ $product ? route('admin.products.edit', ['product' => $product->id, 'step' => 'description']) : route('admin.products.create') }}"
                                class="{{ !$product && $currentStep !== 'description' ? 'disabled' : '' }}">
                                Описание
                            </a>
                        </li>
                        <li class="{{ $currentStep === 'usage' ? 'active' : '' }} text-small">
                            <a href="{{ $product ? route('admin.products.edit', ['product' => $product->id, 'step' => 'usage']) : '#' }}"
                                class="{{ !$product ? 'disabled' : '' }}">
                                Применение
                            </a>
                        </li>
                        <li class="{{ $currentStep === 'advantages' ? 'active' : '' }} text-small">
                            <a href="{{ $product ? route('admin.products.edit', ['product' => $product->id, 'step' => 'advantages']) : '#' }}"
                                class="{{ !$product ? 'disabled' : '' }}">
                                Преимущества
                            </a>
                        </li>
                        <li class="{{ $currentStep === 'characteristics' ? 'active' : '' }} text-small">
                            <a href="{{ $product ? route('admin.products.edit', ['product' => $product->id, 'step' => 'characteristics']) : '#' }}"
                                class="{{ !$product ? 'disabled' : '' }}">
                                Характеристики
                            </a>
                        </li>
                        <li class="{{ $currentStep === 'certificates' ? 'active' : '' }} text-small">
                            <a href="{{ $product ? route('admin.products.edit', ['product' => $product->id, 'step' => 'certificates']) : '#' }}"
                                class="{{ !$product ? 'disabled' : '' }}">
                                Сертификаты
                            </a>
                        </li>
                        <li class="{{ $currentStep === 'faq' ? 'active' : '' }} text-small">
                            <a href="{{ $product ? route('admin.products.edit', ['product' => $product->id, 'step' => 'faq']) : '#' }}"
                                class="{{ !$product ? 'disabled' : '' }}">
                                FAQ
                            </a>
                        </li>
                    </ul>
                </div>
                @yield('product-content')
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Переключение мобильного меню
            const sidebarToggle = document.getElementById('sidebarToggle');
            const productSidebar = document.getElementById('productSidebar');

            if (sidebarToggle && productSidebar) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    productSidebar.classList.toggle('active');
                });
            }

            // Закрытие меню при клике вне его области
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && // Используем lg breakpoint (992px)
                    productSidebar &&
                    !e.target.closest('#productSidebar') &&
                    !e.target.closest('#sidebarToggle') &&
                    productSidebar.classList.contains('active')) {
                    productSidebar.classList.remove('active');
                }
            });
        });
    </script>
@endsection
