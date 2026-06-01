<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Подтверждение заказа #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        h2 { color: #1a1a2e; border-bottom: 2px solid #00b4d8; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f5f5f5; }
        .total { font-size: 18px; font-weight: bold; color: #0f3460; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #888; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h2>Спасибо за ваш заказ!</h2>
    
    <p>Ваш заказ #{{ $order->id }} принят и передан в обработку.</p>
    
    <p><strong>Дата заказа:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
    
    <h3>Детали заказа</h3>
    <table>
        <thead>
            <tr>
                <th>Товар</th>
                <th>Кол-во</th>
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
    
    <h3>Информация о доставке</h3>
    <p><strong>Способ доставки:</strong> 
        @switch($order->delivery_method)
            @case('courier') Курьером @break
            @case('pickup') Самовывоз @break
            @case('mail') Почта @break
            @default {{ $order->delivery_method }}
        @endswitch
    </p>
    <p><strong>Способ оплаты:</strong>
        @switch($order->payment_method)
            @case('cash') Наличными при получении @break
            @case('card') Картой при получении @break
            @case('online') Онлайн оплата @break
            @default {{ $order->payment_method }}
        @endswitch
    </p>
    
    @if($order->customer_comment)
    <p><strong>Ваш комментарий:</strong> {{ $order->customer_comment }}</p>
    @endif
    
    <p style="margin-top: 20px;">Наш менеджер свяжется с вами в ближайшее время для уточнения деталей.</p>
    
    <div class="footer">
        <p>&copy; TechStore. Все права защищены.</p>
        <p>г. Севастополь, ул. Большая Морская, 19 | Тел: +7 (978) 123-45-67</p>
    </div>
</div>
</body>
</html>