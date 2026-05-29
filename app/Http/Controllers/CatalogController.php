<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Список всех категорий (включая архивные)
    public function index()
    {
        $categories = Category::withTrashed()->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Только активные категории
    public function indexActive()
    {
        $categories = Category::orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Только архивные категории
    public function indexArchived()
    {
        $categories = Category::onlyTrashed()->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Форма добавления
    public function create()
    {
        return view('admin.categories.create');
    }

    // Сохранение
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories',
            'sort_order' => 'integer',
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories')->with('success', 'Категория добавлена');
    }

    // Форма редактирования
    public function edit($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Обновление
    public function update(Request $request, $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $id,
            'sort_order' => 'integer',
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories')->with('success', 'Категория обновлена');
    }

    // Мягкое удаление (в архив)
    public function archive($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return redirect()->route('admin.categories')->with('success', 'Категория перемещена в архив');
    }

    // Восстановление из архива
    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        
        return redirect()->route('admin.categories')->with('success', 'Категория восстановлена');
    }

    // Полное удаление
    public function destroy($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        
        return redirect()->route('admin.categories')->with('success', 'Категория удалена навсегда');
    }
}