<?php

use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('home');
})->name('home');

// Каталог
Route::get('/catalog', function () {
    return view('catalog');
})->name('catalog');

// Новости
Route::get('/news', function () {
    return view('news');
})->name('news');

// Услуги
Route::get('/services', function () {
    return view('services');
})->name('services');

// Техподдержка
Route::get('/support', function () {
    return view('support');
})->name('support');

// О компании
Route::get('/about', function () {
    return view('about');
})->name('about');

// Контакты
Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

// Корзина
Route::get('/cart', function () {
    return view('cart');
})->name('cart');