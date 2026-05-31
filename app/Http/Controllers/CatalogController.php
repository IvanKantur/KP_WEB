<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    // Показываем все категории на главной странице каталога
    public function index()
    {
        // Достаем все категории, сортируем по порядку
        $categories = Category::orderBy('sort_order')->get();
        
        // Передаем их в представление catalog.blade.php
        return view('catalog', compact('categories'));
    }

    // Показываем товары в выбранной категории
    public function category($slug)
    {
        // Ищем категорию по slug (url-псевдониму)
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Достаем товары только из этой категории и только активные
        $products = Product::where('category_id', $category->id)
                          ->where('is_active', true)
                          ->get();
        
        return view('category', compact('category', 'products'));
    }

    // Показываем один конкретный товар
    public function product($categorySlug, $productSlug)
    {
        // Ищем товар по slug, подгружаем его категорию
        $product = Product::where('slug', $productSlug)
                         ->with('category')
                         ->firstOrFail();
        
        return view('product', compact('product'));
    }
}