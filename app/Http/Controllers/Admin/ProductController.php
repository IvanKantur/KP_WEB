<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Список всех товаров (включая архивные)
    public function index()
    {
        $products = Product::withTrashed()->with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Только активные товары
    public function indexActive()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Только архивные товары
    public function indexArchived()
    {
        $products = Product::onlyTrashed()->with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Форма добавления товара
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Сохранение нового товара
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products',
            'price' => 'required|numeric',
            'stock' => 'integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        Product::create($data);
        return redirect()->route('admin.products')->with('success', 'Товар добавлен');
    }

    // Форма редактирования товара
    public function edit($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Обновление товара
    public function update(Request $request, $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'price' => 'required|numeric',
            'stock' => 'integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        
        $product->update($data);
        
        return redirect()->route('admin.products')->with('success', 'Товар обновлен');
    }

    // Мягкое удаление (в архив)
    public function archive($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect()->route('admin.products')->with('success', 'Товар перемещен в архив');
    }

    // Восстановление из архива
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        
        return redirect()->route('admin.products')->with('success', 'Товар восстановлен');
    }

    // Полное удаление
    public function destroy($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();
        
        return redirect()->route('admin.products')->with('success', 'Товар удален навсегда');
    }
}