@extends('main')

@section('title', 'Редактировать товар')

@section('content')
<h2>Редактирование товара</h2>

<form method="POST" action="{{ route('admin.products.update', $product->id) }}">
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
    <div class="form-group">
        <label>Активен:</label>
        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
    </div>
    <div class="form-group">
        <label>Рекомендуемый:</label>
        <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}>
    </div>
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.products') }}">← Назад</a>
@endsection