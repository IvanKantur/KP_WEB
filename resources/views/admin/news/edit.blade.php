@extends('main')

@section('title', 'Редактировать новость')

@section('content')
<h2>Редактирование новости: {{ $news->title }}</h2>

<form method="POST" action="{{ route('admin.news.update', $news->id) }}">
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
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.news') }}">← Назад</a>
@endsection