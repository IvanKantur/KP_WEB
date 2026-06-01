<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // Сохранение заказа
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'delivery_method' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'customer_comment' => 'nullable|string',
        ]);

        $cart = json_decode(request()->cookie('cart', '[]'), true);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        
        $total = 0;
        $items = [];
        
        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $subtotal = $product->price * $quantity;
            $total += $subtotal;
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $product->price,
            ];
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_comment' => $request->customer_comment,
            'delivery_method' => $request->delivery_method,
            'payment_method' => $request->payment_method,
            'total_amount' => $total,
            'status' => 'new',
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        //Отправляем письмо клиенту (если указан email)
        if ($request->customer_email) {
            Mail::to($request->customer_email)->send(new OrderConfirmation($order));
        }

        return redirect()->route('cart.success', $order->id)
            ->with('success', 'Заказ оформлен! Номер заказа: #' . $order->id)
            ->withCookie(cookie()->forget('cart'));
    }

    // Страница успешного оформления
    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('cart.success', compact('order'));
    }

    // Админка: список заказов
    public function index()
    {
        $orders = Order::with('items')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    // Админка: просмотр заказа
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Админка: обновить статус заказа
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Статус заказа обновлен');
    }
}