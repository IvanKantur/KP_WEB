@extends('main')

@section('title', 'Редактировать категорию')

@section('content')
<h2>Редактирование категории</h2>

<form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Название:</label>
        <input type="text" name="name" value="{{ $category->name }}" required>
    </div>
    <div class="form-group">
        <label>Фото категории:</label>
        <input type="file" name="image" accept="image/*">
        @if($category->image)
            <p>Текущее фото: <img src="{{ asset('storage/' . $category->image) }}" style="height: 50px;"></p>
        @endif
    </div>
    <div class="form-group">
        <label>Slug (url):</label>
        <input type="text" name="slug" value="{{ $category->slug }}" required>
    </div>
    <div class="form-group">
        <label>Описание:</label>
        <textarea name="description" rows="3">{{ $category->description }}</textarea>
    </div>
    <div class="form-group">
        <label>Порядок сортировки:</label>
        <input type="number" name="sort_order" value="{{ $category->sort_order }}">
    </div>
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.categories') }}">← Назад</a>
@endsection