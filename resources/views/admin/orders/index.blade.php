@extends('main')

@section('title', 'Заказы')

@section('content')
<h2>Управление заказами</h2>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Покупатель</th>
            <th>Телефон</th>
            <th>Сумма</th>
            <th>Статус</th>
            <th>Дата</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>#{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->customer_phone }}</td>
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
            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->id) }}">📋 Просмотр</a>
            </td>
        </tr>
        @endforeach
    </tbody>
\\</table>

{{ $orders->links() }}

<a href="{{ route('admin.index') }}" class="admin-btn info">← Назад в админку</a>
@endsection