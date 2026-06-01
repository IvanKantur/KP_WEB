@extends('main')

@section('title', 'Редактировать товар')

@section('content')
<h2>Редактирование товара</h2>

<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Категория:</label>
        <select name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Название:</label>
        <input type="text" name="name" value="{{ $product->name }}" required>
    </div>
    <div class="form-group">
        <label>Slug (url):</label>
        <input type="text" name="slug" value="{{ $product->slug }}" required>
    </div>
    <div class="form-group">
        <label>Цена (руб):</label>
        <input type="number" name="price" value="{{ $product->price }}" step="1" required>
    </div>
    <div class="form-group">
        <label>Остаток на складе:</label>
        <input type="number" name="stock" value="{{ $product->stock }}">
    </div>
    <div class="form-group">
        <label>Описание:</label>
        <textarea name="description" rows="3">{{ $product->description }}</textarea>
    </div>
    <div class="form-group">
        <label>Характеристики:</label>
        <textarea name="specifications" rows="3">{{ $product->specifications }}</textarea>
    </div>
    
    <!-- Блок для загрузки новых фото -->
    <div class="form-group">
        <label>Добавить фото (до 5 шт.):</label>
        <input type="file" name="images[]" multiple accept="image/*" class="form-control">
        <small>Можно выбрать несколько файлов одновременно (Ctrl+выбор)</small>
    </div>
    
    <!-- Список текущих фото с сортировкой -->
    @if($product->images && $product->images->count() > 0)
    <div class="form-group">
        <label>Текущие фото (перетащите для изменения порядка):</label>
        <div class="sortable-images" id="sortable-images">
            @foreach($product->images as $image)
            <div class="image-item" data-id="{{ $image->id }}" data-order="{{ $image->sort_order }}">
                <img src="{{ asset('storage/' . $image->image) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                <span class="drag-handle">⋮⋮</span>
                <button type="button" class="delete-image" data-id="{{ $image->id }}" title="Удалить">🗑️</button>
            </div>
            @endforeach
        </div>
        <small>Перетащите мышкой для изменения порядка фото</small>
    </div>
    @endif
    
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}> Активен
        </label>
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}> Рекомендуемый
        </label>
    </div>
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.products') }}">← Назад</a>

<style>
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
        // Сохраняем новый порядок
        let items = [];
        document.querySelectorAll('.image-item').forEach((item, index) => {
            items.push({
                id: item.dataset.id,
                order: index
            });
        });
        
        fetch('{{ route("admin.products.image.sort") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Порядок сохранен');
            }
        });
    }
});

// Удаление изображения
document.querySelectorAll('.delete-image').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        let id = this.dataset.id;
        if (confirm('Удалить фото?')) {
            fetch('/admin/products/image/' + id, {
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
            })
            .catch(error => console.error('Ошибка:', error));
        }
    });
});
</script>
@endsection