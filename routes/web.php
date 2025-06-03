<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FroalaController;
use App\Http\Controllers\ObjectController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductAdvantageController;
use App\Http\Controllers\ProductCertificateController;
use App\Http\Controllers\ProductCharacteristicController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFaqController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductUsageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PagesController::class, 'showMain'])->name('view.main');
Route::post('/send-contact', [ContactController::class, 'send'])->name('send.contact');

Route::middleware('admin.check')->group(function () {
    Route::get('/admin-action', [AdminController::class, 'showAdmin'])->name('view.admin');
    Route::get('/admin-objects', [AdminController::class, 'showAdminObjects'])->name('view.admin.objects');
    Route::get('/admin-blogs', [AdminController::class, 'showAdminBlogs'])->name('view.admin.blogs');

    Route::get('/blog/create', [BlogController::class, 'showCreateBlog'])->name('view.blog.create');
    Route::post('/blog/store', [BlogController::class, 'createBlog'])->name('blog.create');
    Route::post('/upload-blog-description-image', [BlogController::class, 'uploadDescriptionImage'])
        ->name('blog.image.description.upload');
    Route::get('/blog/{id}/edit', [BlogController::class, 'showUpdateBlog'])->name('view.blog.update');
    Route::put('/blog/{id}/update', [BlogController::class, 'updateBlog'])->name('blog.update');
    Route::post('/blog/image/upload', [BlogController::class, 'uploadBlogImage'])->name('blog.image.upload');
    Route::post('/blog/image/delete', [BlogController::class, 'deleteBlogImage'])->name('blog.image.delete');
    Route::delete('/blogs/{blog}/delete', [BlogController::class, 'destroy'])->name('blogs.destroy');

    Route::get('/object/create', [ObjectController::class, 'showCreateObject'])->name('view.object.create');
    Route::post('/object/store', [ObjectController::class, 'createObject'])->name('object.create');
    Route::post('/upload-object-description-image', [ObjectController::class, 'uploadDescriptionImage'])
        ->name('object.image.description.upload');
    Route::get('/object/{id}/edit', [ObjectController::class, 'showUpdateObject'])->name('view.object.update');
    Route::put('/object/{id}/update', [ObjectController::class, 'updateObject'])->name('object.update');
    Route::post('/object/image/upload', [ObjectController::class, 'uploadObjectImage'])->name('object.image.upload');
    Route::post('/object/image/delete', [ObjectController::class, 'deleteObjectImage'])->name('object.image.delete');
    Route::delete('/objects/{object}/delete', [ObjectController::class, 'destroy'])->name('objects.destroy');


    Route::prefix('admin/products')->name('admin.products.')->group(function () {
        // Основные маршруты товаров
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit/{step?}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}/delete', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/upload-description-image', [ProductController::class, 'uploadDescriptionImage'])
            ->name('images.upload');

        // Маршруты для изображений товаров
        Route::post('/images/temp-delete', [ProductImageController::class, 'tempDeleteImage'])->name('images.temp-delete');
        Route::post('/images/temp-upload', [ProductImageController::class, 'tempUploadImage'])->name('images.temp-upload');
        Route::post('/image/delete', [ProductImageController::class, 'destroy'])->name('images.destroy');

        // Маршруты для этапов
        Route::post('/{product}/usage', [ProductUsageController::class, 'store'])->name(name: 'usage.store');
        Route::post('/{product}/advantages', [ProductAdvantageController::class, 'store'])->name('advantages.store');

        // Модификации
        Route::post('/{product}/modifications/store-modification', [ProductCharacteristicController::class, 'storeModification'])
            ->name('modifications.store');
        Route::put('/{product}/modifications/{modification}', [ProductCharacteristicController::class, 'updateModification'])
            ->name('modifications.update');
        Route::delete('/{product}/modifications/{modification}', [ProductCharacteristicController::class, 'destroyModification'])
            ->name('modifications.destroy');

        // Характеристики
        Route::post('characteristics/store', [ProductCharacteristicController::class, 'storeCharacteristic'])
            ->name('characteristics.store');
        Route::put('characteristics/{characteristic}', [ProductCharacteristicController::class, 'updateCharacteristic'])
            ->name('characteristics.update');
        Route::delete('characteristics/{characteristic}', [ProductCharacteristicController::class, 'destroyCharacteristic'])
            ->name('characteristics.destroy');

        // Значения характеристик
        Route::post('/{product}/values/store', [ProductCharacteristicController::class, 'storeValue'])
            ->name('values.store');
        Route::put('/{product}/values/{value}', [ProductCharacteristicController::class, 'updateValue'])
            ->name('values.update');
        Route::delete('/{product}/values/{value}', [ProductCharacteristicController::class, 'destroyValue'])
            ->name('values.destroy');

        // Финализация этапа
        Route::post('/{product}/modifications/finalize', [ProductCharacteristicController::class, 'finalize'])
            ->name('modifications.finalize');
        Route::post('/{product}/faq', [ProductFaqController::class, 'store'])->name('faq.store');

        // Маршруты для изображений преимуществ
        Route::post('/advantages/images/temp-upload', [ProductImageController::class, 'tempUploadImage'])->name('advantages.images.temp-upload');
        Route::delete('/advantages/images/{image}', [ProductAdvantageController::class, 'destroyImage'])->name('advantages.images.destroy');

        // Маршруты для сертификатов

        Route::post('/{product}/certificates', [ProductCertificateController::class, 'store'])
            ->name('certificates.store');

        Route::delete('/{product}/certificates/{certificate}', [ProductCertificateController::class, 'destroy'])
            ->name('certificates.destroy');

        // Temporary routes
        Route::post('/certificates/temp-upload', [ProductCertificateController::class, 'tempUploadCertificate'])
            ->name('certificates.temp-upload');

        Route::post('/certificates/temp-delete', [ProductCertificateController::class, 'tempDeleteCertificate'])
            ->name('certificates.temp-delete');


        Route::post('/{product}/advantages/order', [ProductAdvantageController::class, 'updateOrder'])->name('advantages.order');
        Route::post('/update-order', [ProductController::class, 'updateOrder'])->name('update-order');
    });

    Route::post('/temp-upload-object-image', [ProductImageController::class, 'tempUploadImage']);
    Route::post('/temp-delete-object-image', [ProductImageController::class, 'tempDeleteImage']);

    Route::post('/temp-upload-blog-image', [ProductImageController::class, 'tempUploadImage']);
    Route::post('/temp-delete-blog-image', [ProductImageController::class, 'tempDeleteImage']);

    Route::post('/upload_image', [FroalaController::class, 'upload'])->name('upload_image');
    Route::post('/delete_image', [FroalaController::class, 'delete'])->name('delete_image');
});

Route::get('/objects/filter', [PagesController::class, 'filterObjects'])->name('objects.filter');
Route::get('/about', [PagesController::class, 'showAbout'])->name('view.about');
Route::get('/contacts', [PagesController::class, 'showContacts'])->name('view.contacts');
Route::get('/catalog', [ProductController::class, 'showCatalog'])->name('view.catalog');
Route::get('/product/{id}', [ProductController::class, 'showProduct'])->name('view.product');
Route::get('/blogs', [BlogController::class, 'showBlogs'])->name('view.blogs');
Route::get('/blog/{id}', [BlogController::class, 'showBlog'])->name('view.blog');
Route::get('/objects', [ObjectController::class, 'showObjects'])->name('view.objects');
Route::get('/object/{id}', [ObjectController::class, 'showObject'])->name('view.object');
Route::get('/admin', [AdminController::class, 'showLogin'])->name('view.login');
Route::post('/login/store', [AdminController::class, 'login'])->name('login');
Route::get('/logs', function () {
    $logPath = storage_path('logs/laravel.log');
    if (file_exists($logPath)) {
        return nl2br(file_get_contents($logPath));
    }
    return 'Логи не найдены';
});
