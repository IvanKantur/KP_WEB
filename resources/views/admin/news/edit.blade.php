@extends('main')

@section('title', 'Редактировать новость')

@section('content')
<h2>Редактирование новости: {{ $news->title }}</h2>

<form method="POST" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Заголовок:</label>
        <input type="text" name="title" value="{{ $news->title }}" required>
    </div>
    <div class="form-group">
        <label>Slug (url):</label>
        <input type="text" name="slug" value="{{ $news->slug }}" required>
    </div>
    <div class="form-group">
        <label>Анонс:</label>
        <textarea name="announce" rows="3">{{ $news->announce }}</textarea>
    </div>
    <div class="form-group">
        <label>Полный текст:</label>
        <textarea name="content" class="editor" rows="10">{{ $news->content }}</textarea>
    </div>
    <div class="form-group">
        <label>Дата публикации:</label>
        <input type="date" name="published_at" value="{{ $news->published_at ? $news->published_at->format('Y-m-d') : '' }}">
    </div>
    <div class="form-group">
        <label>Фото (максимум 2 шт.):</label>
        <input type="file" name="images[]" multiple accept="image/*">
    </div>
    @if($news->images && $news->images->count() > 0)
    <div class="form-group">
        <label>Текущие фото:</label>
        <div class="current-images">
            @foreach($news->images as $img)
            <div class="image-item" data-id="{{ $img->id }}">
                <img src="{{ asset('storage/' . $img->image) }}" style="width: 80px; height: 80px; object-fit: cover;">
                <button type="button" class="delete-image" data-id="{{ $img->id }}">🗑️</button>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_active" value="1" {{ $news->is_active ? 'checked' : '' }}> Опубликовать
        </label>
    </div>
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.news') }}">← Назад</a>

<script>
    // Удаление изображения
    document.querySelectorAll('.delete-image').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            let id = this.dataset.id;
            if (confirm('Удалить фото?')) {
                fetch('{{ url("/admin/news/image") }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.image-item').remove();
                    }
                });
            }
        });
    });
</script>

<style>
    .current-images {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .image-item {
        position: relative;
        border: 1px solid var(--gray-border);
        border-radius: 8px;
        padding: 5px;
        background: var(--white);
    }
    .delete-image {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        cursor: pointer;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .delete-image:hover {
        background: #c82333;
    }
</style>
@endsection