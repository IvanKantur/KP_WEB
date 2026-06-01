<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    //Список всех новостей (включая архивные)
    public function index()
    {
        $news = News::withTrashed()->orderBy('published_at', 'desc')->get();
        return view('admin.news.index', compact('news'));
    }

    //Только активные новости
    public function indexActive()
    {
        $news = News::orderBy('published_at', 'desc')->get();
        return view('admin.news.index', compact('news'));
    }

    //Только архивные новости
    public function indexArchived()
    {
        $news = News::onlyTrashed()->orderBy('published_at', 'desc')->get();
        return view('admin.news.index', compact('news'));
    }

    //Форма добавления
    public function create()
    {
        return view('admin.news.create');
    }

    //Сохранение новости
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:news',
            'announce' => 'nullable|string',
            'content' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['slug'] = Str::slug($request->slug);

        News::create($data);

        return redirect()->route('admin.news')->with('success', 'Новость добавлена');
    }

    //Форма редактирования
    public function edit($id)
    {
        $news = News::withTrashed()->findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    //Обновление новости
    public function update(Request $request, $id)
    {
        $news = News::withTrashed()->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:news,slug,' . $id,
            'announce' => 'nullable|string',
            'content' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['slug'] = Str::slug($request->slug);

        $news->update($data);

        return redirect()->route('admin.news')->with('success', 'Новость обновлена');
    }

    //Мягкое удаление (в архив)
    public function archive($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('admin.news')->with('success', 'Новость перемещена в архив');
    }

    //Восстановление из архива
    public function restore($id)
    {
        $news = News::onlyTrashed()->findOrFail($id);
        $news->restore();

        return redirect()->route('admin.news')->with('success', 'Новость восстановлена');
    }

    //Полное удаление
    public function destroy($id)
    {
        $news = News::withTrashed()->findOrFail($id);
        $news->forceDelete();

        return redirect()->route('admin.news')->with('success', 'Новость удалена навсегда');
    }
}