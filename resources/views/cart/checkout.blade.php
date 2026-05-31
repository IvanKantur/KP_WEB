@extends('main')

@section('title', 'Оформление заказа')

@section('content')
<h2>Оформление заказа</h2>

<div class="checkout-layout">
    <!-- Список товаров -->
    <div class="checkout-products">
        <h3>Ваш заказ</h3>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Кол-во</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ number_format($product['subtotal'], 0, ',', ' ') }} ₽</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: right;"><strong>Итого:</strong></td>
                    <td><strong class="checkout-summary">{{ number_format($total, 0, ',', ' ') }} ₽</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Форма заказа -->
    <div class="checkout-form">
        <h3>Контактные данные</h3>
        <form method="POST" action="{{ route('order.store') }}">
            @csrf
            <div class="form-group">
                <label>ФИО: <span class="required">*</span></label>
                <input type="text" name="customer_name" required>
            </div>
            <div class="form-group">
                <label>Телефон: <span class="required">*</span></label>
                <input type="tel" name="customer_phone" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="customer_email">
            </div>
            <div class="form-group">
                <label>Способ доставки:</label>
                <select name="delivery_method">
                    <option value="courier">Курьером</option>
                    <option value="pickup">Самовывоз</option>
                    <option value="mail">Почта</option>
                </select>
            </div>
            <div class="form-group">
                <label>Способ оплаты:</label>
                <select name="payment_method">
                    <option value="cash">Наличными при получении</option>
                    <option value="card">Картой при получении</option>
                    <option value="online">Онлайн оплата</option>
                </select>
            </div>
            <div class="form-group">
                <label>Комментарий к заказу:</label>
                <textarea name="customer_comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn">Подтвердить заказ</button>
        </form>
    </div>
</div>

<a href="{{ route('cart') }}" class="back-link">← Вернуться в корзину</a>
@endsection