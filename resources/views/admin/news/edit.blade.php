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
    <div class="form-group">
        <label>Добавить фото (максимум 2 всего):</label>
        <input type="file" name="images[]" multiple accept="image/*">
        <small>Можно добавить еще фото (всего не более 2)</small>
    </div>

    @if($news->images->count() > 0)
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
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.news') }}">← Назад</a>
@endsection