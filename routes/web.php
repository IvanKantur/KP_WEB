<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;

// Главная страница
Route::get('/', function () {
    return view('home');
})->name('home');

// Маршруты каталога
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/catalog/{slug}', [CatalogController::class, 'category'])->name('category');
Route::get('/catalog/{categorySlug}/{productSlug}', [CatalogController::class, 'product'])->name('product');

// Остальные страницы
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