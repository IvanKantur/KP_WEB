<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    /**
     * Главная страница админ-панели
     * Показывает статистику по сайту
     */
    public function index()
    {
        // Считаем количество записей
        $usersCount = User::count();
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        
        return view('admin.index', compact('usersCount', 'categoriesCount', 'productsCount', 'ordersCount'));
    }
}