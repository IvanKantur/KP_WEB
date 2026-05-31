@extends('main')

@section('title', 'Заказ оформлен')

@section('content')
<h2>Заказ успешно оформлен!</h2>

<div class="success-box">
    <div class="success-icon">✅</div>
    <p>Спасибо за ваш заказ!</p>
    <p>Номер вашего заказа: <strong>#{{ $order->id }}</strong></p>
    <p>Сумма заказа: <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong></p>
    <p>Статус: <strong>Новый</strong></p>
    <p>Мы свяжемся с вами в ближайшее время.</p>
    
    <div class="order-details">
        <h3>Детали заказа</h3>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }} шт.</td>
                    <td>{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                    <td>{{ number_format($item->quantity * $item->price, 0, ',', ' ') }} ₽</td>
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
</div>

<div class="success-actions">
    <a href="{{ route('catalog') }}" class="btn">Продолжить покупки</a>
    <a href="{{ route('cart') }}" class="btn btn-outline">Вернуться в корзину</a>
</div>

<style>
.success-box {
    background: #d4edda;
    color: #155724;
    padding: 30px;
    border-radius: 16px;
    text-align: center;
    margin: 30px 0;
    border-left: 4px solid #28a745;
}

.success-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.success-box p {
    margin: 15px 0;
    font-size: 1.1rem;
}

.order-details {
    margin-top: 30px;
    text-align: left;
}

.order-details h3 {
    margin-bottom: 15px;
    color: var(--black);
}

.success-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 20px;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--blue-dark);
    color: var(--blue-dark);
}

.btn-outline:hover {
    background: var(--blue-dark);
    color: var(--white);
}
</style>
@endsection