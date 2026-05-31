@extends('main')

@section('title', 'Профиль пользователя')

@section('content')
<h2>Профиль пользователя</h2>

<div class="user-profile" style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Имя:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Роль:</strong> {{ $user->is_admin ? 'Администратор' : 'Пользователь' }}</p>
    <p><strong>Дата регистрации:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
</div>

<h3>История заказов</h3>

@if($orders->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>№ заказа</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</td>
                <td>
                    @switch($order->status)
                        @case('new') <span style="color: blue;">Новый</span> @break
                        @case('processing') <span style="color: orange;">В обработке</span> @break
                        @case('completed') <span style="color: green;">Выполнен</span> @break
                        @case('cancelled') <span style="color: red;">Отменен</span> @break
                        @default {{ $order->status }}
                    @endswitch
                </td>
                <td>
                    <a href="#">Подробнее</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>У пользователя пока нет заказов.</p>
@endif

<a href="{{ route('admin.users') }}" class="admin-btn info" style="display: inline-block;">← Назад к списку</a>

<style>
    .user-profile p {
        margin: 10px 0;
    }
</style>
@endsection