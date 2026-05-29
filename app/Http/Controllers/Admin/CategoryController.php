<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //Список всех категорий. Сортировка по полю sort_order (порядок вывода)
    public function index()
    {
        $categories = Category::orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Форма добавления новой категории
    public function create()
    {
        return view('admin.categories.create');
    }

    //Сохранение новой категории в БД. Проверяем что имя и slug заполнены, slug уникальный
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',      // название обязательно
            'slug' => 'required|string|unique:categories', // slug уникальный
            'sort_order' => 'integer',                // порядок сортировки
        ]);

        Category::create($request->all());
        
        // Редирект с сообщением об успехе
        return redirect()->route('admin.categories')->with('success', 'Категория добавлена');
    }

    // Форма редактирования категории
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    //Обновление категории, при обновлении проверяем уникальность slug, исключая текущую категорию
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $id, // исключаем текущий ID
            'sort_order' => 'integer',
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories')->with('success', 'Категория обновлена');
    }

    //Удаление категории, вместе с категорией удалятся все товары из-за onDelete('cascade')
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return redirect()->route('admin.categories')->with('success', 'Категория удалена');
    }

    // Только активные категории
public function indexActive()
{
    $categories = Category::orderBy('sort_order')->get();
    return view('admin.categories.index', compact('categories'));
}

// Только архивные
public function indexArchived()
{
    $categories = Category::onlyTrashed()->orderBy('sort_order')->get();
    return view('admin.categories.index', compact('categories'));
}

// Восстановление из архива
public function restore($id)
{
    $category = Category::onlyTrashed()->findOrFail($id);
    $category->restore();
    
    return redirect()->route('admin.categories')->with('success', 'Категория восстановлена');
}
}