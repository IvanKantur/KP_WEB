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
        <textarea name="content" rows="10">{{ $news->content }}</textarea>
    </div>
    <div class="form-group">
        <label>Дата публикации:</label>
        <input type="date" name="published_at" value="{{ $news->published_at ? $news->published_at->format('Y-m-d') : '' }}">
    </div>
    
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_active" value="1" {{ $news->is_active ? 'checked' : '' }}> Опубликовать
        </label>
    </div>
    
    <!-- Блок для загрузки новых фото -->
    <div class="form-group">
        <label>Добавить фото (максимум 2 всего):</label>
        <input type="file" name="images[]" multiple accept="image/*">
        <small>Можно выбрать несколько файлов (всего не более 2)</small>
    </div>
    
    <!-- Текущие фото с сортировкой -->
    @if($news->images && $news->images->count() > 0)
    <div class="form-group">
        <label>Текущие фото (перетащите для изменения порядка):</label>
        <div class="sortable-images" id="sortable-images">
            @foreach($news->images as $img)
            <div class="image-item" data-id="{{ $img->id }}" data-order="{{ $img->sort_order }}">
                <img src="{{ asset('storage/' . $img->image) }}" class="image-thumb">
                <span class="drag-handle">⋮⋮</span>
                <button type="button" class="delete-image" data-id="{{ $img->id }}" title="Удалить">🗑️</button>
            </div>
            @endforeach
        </div>
        <small>Перетащите мышкой для изменения порядка фото</small>
    </div>
    @endif
    
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.news') }}">← Назад</a>

<style>
.image-thumb {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}
.sortable-images {
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
    cursor: move;
}
.drag-handle {
    position: absolute;
    bottom: 5px;
    left: 5px;
    background: rgba(0,0,0,0.5);
    color: white;
    font-size: 14px;
    padding: 2px 6px;
    border-radius: 4px;
    cursor: move;
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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Сортировка фото
var sortable = new Sortable(document.getElementById('sortable-images'), {
    animation: 150,
    onEnd: function() {
        let items = [];
        document.querySelectorAll('.image-item').forEach((item, index) => {
            items.push({
                id: item.dataset.id,
                order: index
            });
        });
        
        fetch('{{ route("admin.news.image.sort") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) console.log('Порядок сохранен');
        });
    }
});

// Удаление изображения
document.querySelectorAll('.delete-image').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        let id = this.dataset.id;
        if (confirm('Удалить фото?')) {
            fetch('{{ route("admin.news.image.delete", "id") }}'.replace('id', id), {
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
@endsection