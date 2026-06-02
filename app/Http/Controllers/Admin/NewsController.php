<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['slug'] = Str::slug($request->slug);

        $news = News::create($data);

        //Обработка фото (максимум 2)
        if ($request->hasFile('images')) {
            $sortOrder = 0;
            foreach ($request->file('images') as $file) {
                if ($sortOrder >= 2) break;
                $path = $file->store('news', 'public');
                NewsImage::create([
                    'news_id' => $news->id,
                    'image' => $path,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('admin.news')->with('success', 'Новость добавлена');
    }

    //Форма редактирования
    public function edit($id)
    {
        $news = News::withTrashed()->with('images')->findOrFail($id);
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['slug'] = Str::slug($request->slug);

        $news->update($data);

        //Добавление новых фото (максимум 2 всего)
        if ($request->hasFile('images')) {
            $currentCount = $news->images->count();
            $sortOrder = $currentCount;
            foreach ($request->file('images') as $file) {
                if ($sortOrder >= 2) break;
                $path = $file->store('news', 'public');
                NewsImage::create([
                    'news_id' => $news->id,
                    'image' => $path,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('admin.news')->with('success', 'Новость обновлена');
    }

    //Удаление фото
    public function deleteImage($id)
    {
        $image = NewsImage::findOrFail($id);
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['success' => true]);
    }

    // Сортировка изображений
    public function sortImages(Request $request)
    {
        $items = $request->input('items', []);
        
        foreach ($items as $item) {
            NewsImage::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }
        
        return response()->json(['success' => true]);
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
        
        //Удаляем все фото новости
        foreach ($news->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }
        
        $news->forceDelete();

        return redirect()->route('admin.news')->with('success', 'Новость удалена навсегда');
    }
}