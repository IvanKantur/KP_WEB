<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

// Главная страница
Route::get('/', function () {
    return view('home');
})->name('home');

// Маршруты каталога (доступны всем)
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/catalog/{slug}', [CatalogController::class, 'category'])->name('category');
Route::get('/catalog/{categorySlug}/{productSlug}', [CatalogController::class, 'product'])->name('product');

// Статические страницы
Route::get('/news', function () {
    return view('news');
})->name('news');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// ========== АДМИНСКИЕ МАРШРУТЫ ==========
// Все маршруты с префиксом /admin и именем admin.*
// Доступны только авторизованным пользователям (middleware 'auth')
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Главная админки
    Route::get('/', [AdminController::class, 'index'])->name('index');
    
    // ===== Управление категориями =====
    // Основные CRUD
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/active', [CategoryController::class, 'indexActive'])->name('categories.active');
    Route::get('/categories/archived', [CategoryController::class, 'indexArchived'])->name('categories.archived');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    
    // Архивация и восстановление
    Route::delete('/categories/{id}/archive', [CategoryController::class, 'archive'])->name('categories.archive');
    Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    
    // Полное удаление
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // ===== Управление товарами =====
    // Основные CRUD
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/active', [ProductController::class, 'indexActive'])->name('products.active');
    Route::get('/products/archived', [ProductController::class, 'indexArchived'])->name('products.archived');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    
    // Архивация и восстановление
    Route::delete('/products/{id}/archive', [ProductController::class, 'archive'])->name('products.archive');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    
    // Полное удаление
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Маршруты аутентификации (логин, регистрация, выход)
Auth::routes();