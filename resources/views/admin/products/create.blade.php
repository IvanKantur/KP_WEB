@extends('main')

@section('title', 'Добавить товар')

@section('content')
<h2>Добавление товара</h2>

<form method="POST" action="{{ route('admin.products.store') }}">
    @csrf
    <div class="form-group">
        <label>Категория:</label>
        <select name="category_id" required>
            <option value="">Выберите</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Название:</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Slug (url):</label>
        <input type="text" name="slug" required>
        <small>например: intel-core-i5-13400</small>
    </div>
    <div class="form-group">
        <label>Цена (руб):</label>
        <input type="number" name="price" step="1" required>
    </div>
    <div class="form-group">
        <label>Остаток на складе:</label>
        <input type="number" name="stock" value="0">
    </div>
    <div class="form-group">
        <label>Описание:</label>
        <textarea name="description" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label>Характеристики:</label>
        <textarea name="specifications" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label>Активен:</label>
        <input type="checkbox" name="is_active" value="1" checked>
    </div>
    <div class="form-group">
        <label>Рекомендуемый:</label>
        <input type="checkbox" name="is_featured" value="1">
    </div>
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.products') }}">← Назад</a>
@endsection