@extends('main')

@section('title', 'Добавить категорию')

@section('content')
<h2>Добавление категории</h2>

<form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Название:</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Фото категории:</label>
        <input type="file" name="image" accept="image/*">
    </div>
    <div class="form-group">
        <label>Slug (url):</label>
        <input type="text" name="slug" required>
        <small>например: processors, video-cards</small>
    </div>
    <div class="form-group">
        <label>Описание:</label>
        <textarea name="description" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label>Порядок сортировки:</label>
        <input type="number" name="sort_order" value="0">
    </div>
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.categories') }}">← Назад</a>
@endsection