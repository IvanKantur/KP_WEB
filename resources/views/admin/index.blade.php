@extends('main')

@section('title', 'Панель администратора')

@section('content')
<h2>Панель администратора</h2>

<div class="admin-stats">
    <div class="stat-card">
        <h3>Пользователи</h3>
        <p>{{ $usersCount }}</p>
        <a href="{{ route('admin.users') }}">Управление</a>
    </div>
    <div class="stat-card">
        <h3>Категории</h3>
        <p>{{ $categoriesCount }}</p>
        <a href="{{ route('admin.categories') }}">Управление</a>
    </div>
    <div class="stat-card">
        <h3>Товары</h3>
        <p>{{ $productsCount }}</p>
        <a href="{{ route('admin.products') }}">Управление</a>
    </div>
    <div class="stat-card">
        <h3>Заказы</h3>
        <p>{{ $ordersCount }}</p>
    </div>
</div>
@endsection