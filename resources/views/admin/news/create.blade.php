@extends('main')

@section('title', 'Добавить новость')

@section('content')
<h2>Добавление новости</h2>

<form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Заголовок:</label>
        <input type="text" name="title" required>
    </div>
    <div class="form-group">
        <label>Slug (url):</label>
        <input type="text" name="slug" required>
        <small>пример: skidki-na-videokarty</small>
    </div>
    <div class="form-group">
        <label>Анонс (кратко):</label>
        <textarea name="announce" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label>Полный текст:</label>
        <textarea name="content" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label>Дата публикации:</label>
        <input type="date" name="published_at">
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_active" value="1" checked> Опубликовать
        </label>
    </div>
    <div class="form-group">
        <label>Фото (максимум 2 шт.):</label>
        <input type="file" name="images[]" multiple accept="image/*">
        <small>Можно выбрать до 2 файлов</small>
    </div>
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.news') }}">← Назад</a>
@endsection