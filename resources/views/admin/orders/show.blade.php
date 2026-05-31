@extends('main')

@section('title', 'Заказ #' . $order->id)

@section('content')
<h2>Заказ #{{ $order->id }}</h2>

<div class="order-info">
    <div class="order-section">
        <h3>Информация о покупателе</h3>
        <p><strong>ФИО:</strong> {{ $order->customer_name }}</p>
        <p><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email ?: 'не указан' }}</p>
        <p><strong>Доставка:</strong> 
            @switch($order->delivery_method)
                @case('courier') Курьером @break
                @case('pickup') Самовывоз @break
                @case('mail') Почта @break
                @default {{ $order->delivery_method }}
            @endswitch
        </p>
        <p><strong>Оплата:</strong>
            @switch($order->payment_method)
                @case('cash') Наличными при получении @break
                @case('card') Картой при получении @break
                @case('online') Онлайн оплата @break
                @default {{ $order->payment_method }}
            @endswitch
        </p>
        <p><strong>Комментарий:</strong> {{ $order->customer_comment ?: 'нет' }}</p>
    </div>

    <div class="order-section">
        <h3>Статус заказа</h3>
        <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
            @csrf
            <select name="status" style="padding: 8px; border-radius: 5px;">
                <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>🆕 Новый</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ В обработке</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Выполнен</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Отменен</option>
            </select>
            <button type="submit" class="btn-small">Сохранить</button>
        </form>
    </div>
</div>

<div class="order-items">
    <h3>Товары в заказе</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                <td>{{ $item->quantity }} шт.</td>
                <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Итого:</strong></td>
                <td><strong>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong></td>
            </tr>
        </tfoot>
    </table>
</div>

<a href="{{ route('admin.orders') }}" class="admin-btn info">← Назад к списку заказов</a>

<style>
.order-info {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.order-section {
    flex: 1;
    background: var(--gray-light);
    padding: 20px;
    border-radius: 12px;
}

.order-section h3 {
    margin-top: 0;
    margin-bottom: 15px;
    color: var(--black);
}

.order-section p {
    margin: 10px 0;
}
</style>
@endsection