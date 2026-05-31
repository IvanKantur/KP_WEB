<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


// Главная страница
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home', function () {
    return redirect('/');
});

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

// Маршруты корзины
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// AJAX маршруты для корзины (динамическое обновление)
Route::post('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.update-all');
Route::post('/cart/remove-all', [CartController::class, 'removeItem'])->name('cart.remove-all');
Route::post('/cart/clear-all', [CartController::class, 'clearAll'])->name('cart.clear-all');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

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
    // Заказы
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
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
    // ===== Управление пользователями =====
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/make-admin', [UserController::class, 'makeAdmin'])->name('users.make-admin');
    Route::post('/users/{id}/remove-admin', [UserController::class, 'removeAdmin'])->name('users.remove-admin');
    });


// Маршруты для заказов
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('cart.success');

// Заказы
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
// Маршруты аутентификации (логин, регистрация, выход)
Auth::routes();