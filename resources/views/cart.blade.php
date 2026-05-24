@extends('main')

@section('title', 'Корзина')

@section('content')
<h2>Корзина</h2>

<div class="cart-empty">
    <p>🛒 Ваша корзина пуста.</p>
    <p>Перейдите в <a href="{{ url('/catalog') }}">каталог</a>, чтобы добавить товары.</p>
</div>

<p class="note">* Функционал корзины будет реализован после настройки базы данных.</p>
@endsection