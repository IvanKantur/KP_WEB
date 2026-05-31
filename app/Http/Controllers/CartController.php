<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Получить корзину из куки
    private function getCart()
    {
        $cart = request()->cookie('cart');
        if ($cart) {
            return json_decode($cart, true);
        }
        return [];
    }

    // Сохранить корзину в куки
    private function saveCart($cart)
    {
        return cookie('cart', json_encode($cart), 60 * 24 * 7);
    }

    // Получить количество товаров в корзине
    public function getCount()
    {
        $cart = $this->getCart();
        $count = array_sum($cart);
        return response()->json(['count' => $count]);
    }

    // Страница корзины
    public function index()
    {
        $cart = $this->getCart();
        $products = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $productsList = Product::whereIn('id', $productIds)->get();

            foreach ($productsList as $product) {
                $quantity = $cart[$product->id];
                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    // Добавить товар в корзину
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = $this->getCart();
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }

        $count = array_sum($cart);

        // Для AJAX запросов возвращаем JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count' => $count,
                'message' => 'Товар добавлен в корзину'
            ])->withCookie($this->saveCart($cart));
        }

        // Для обычных запросов редирект
        return redirect()->route('cart')
            ->with('success', 'Товар добавлен в корзину')
            ->withCookie($this->saveCart($cart));
    }

    // Обновить количество товара
    public function update(Request $request, $id)
    {
        $cart = $this->getCart();
        $quantity = (int)$request->input('quantity');

        if ($quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $quantity;
        }

        return redirect()->route('cart')
            ->with('success', 'Корзина обновлена')
            ->withCookie($this->saveCart($cart));
    }

    // Удалить товар из корзины
    public function remove($id)
    {
        $cart = $this->getCart();
        unset($cart[$id]);

        return redirect()->route('cart')
            ->with('success', 'Товар удален из корзины')
            ->withCookie($this->saveCart($cart));
    }

    // Очистить корзину
    public function clear()
    {
        return redirect()->route('cart')
            ->with('success', 'Корзина очищена')
            ->withCookie(cookie()->forget('cart'));
    }

    // Форма оформления заказа
    public function checkout()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $products = [];
        $total = 0;
        $productIds = array_keys($cart);
        $productsList = Product::whereIn('id', $productIds)->get();

        foreach ($productsList as $product) {
            $quantity = $cart[$product->id];
            $products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
            ];
            $total += $product->price * $quantity;
        }

        return view('cart.checkout', compact('products', 'total'));
    }

    // Обновление всех товаров сразу (AJAX)
    public function updateAll(Request $request)
    {
        $cart = $this->getCart();
        $items = $request->input('items', []);
        
        foreach ($items as $item) {
            $id = $item['id'];
            $quantity = (int)$item['quantity'];
            
            if ($quantity <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id] = $quantity;
            }
        }
        
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        $total = 0;
        $responseItems = [];
        
        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $subtotal = $product->price * $quantity;
            $total += $subtotal;
            $responseItems[] = [
                'id' => $product->id,
                'subtotal' => $subtotal,
                'subtotal_formatted' => number_format($subtotal, 0, ',', ' ') . ' ₽',
            ];
        }
        
        return response()->json([
            'success' => true,
            'items' => $responseItems,
            'total_formatted' => number_format($total, 0, ',', ' ') . ' ₽',
        ])->withCookie($this->saveCart($cart));
    }

    // Удаление одного товара (AJAX)
    public function removeItem(Request $request)
    {
        $cart = $this->getCart();
        $id = $request->input('id');
        
        unset($cart[$id]);
        
        $total = 0;
        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get();
            foreach ($products as $product) {
                $total += $product->price * $cart[$product->id];
            }
        }
        
        return response()->json([
            'success' => true,
            'total_formatted' => number_format($total, 0, ',', ' ') . ' ₽',
            'cart_empty' => empty($cart),
        ])->withCookie($this->saveCart($cart));
    }

    // Очистка всей корзины (AJAX)
    public function clearAll()
    {
        return response()->json([
            'success' => true,
        ])->withCookie(cookie()->forget('cart'));
    }
}