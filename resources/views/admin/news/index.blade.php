@extends('main')

@section('title', 'Управление новостями')

@section('content')
<h2>Управление новостями</h2>

<div class="admin-buttons">
    <a href="{{ route('admin.news') }}" class="admin-btn info">📋 Все</a>
    <a href="{{ route('admin.news.active') }}" class="admin-btn success">✓ Активные</a>
    <a href="{{ route('admin.news.archived') }}" class="admin-btn warning">📦 Архив</a>
    <a href="{{ route('admin.news.create') }}" class="admin-btn">➕ Добавить</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Фото</th>
            <th>Заголовок</th>
            <th>Slug</th>
            <th>Дата</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($news as $item)
        <tr class="{{ $item->trashed() ? 'archived-row' : '' }}">
            <td>{{ $item->id }}</td>
            <td>
                @if($item->firstImage)
                    <img src="{{ asset('storage/' . $item->firstImage->image) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                @else
                    <span style="color: #ccc;">📷</span>
                @endif
            </td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->slug }}</td>
            <td>{{ $item->published_at ? $item->published_at->format('d.m.Y') : '-' }}</td>
            <td>
                @if($item->trashed())
                    <span style="color: #fd7e14;">📦 В архиве</span>
                @else
                    <span style="color: {{ $item->is_active ? '#28a745' : '#6c757d' }};">
                        {{ $item->is_active ? '✓ Опубликовано' : '✗ Черновик' }}
                    </span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.news.edit', $item->id) }}" title="Ред.">✏️</a>
                @if($item->trashed())
                    <form action="{{ route('admin.news.restore', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" title="Восстановить" style="background:none; border:none; color:#28a745; cursor:pointer;">🔄</button>
                    </form>
                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Удалить навсегда" style="background:none; border:none; color:#dc3545; cursor:pointer;" onclick="return confirm('Удалить навсегда?')">💀</button>
                    </form>
                @else
                    <form action="{{ route('admin.news.archive', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="В архив" style="background:none; border:none; color:#fd7e14; cursor:pointer;" onclick="return confirm('Отправить в архив?')">📦</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center;">Новостей не найдено</td>
        </tr>
        @endforelse
    </tbody>
\\</table>

<a href="{{ route('admin.index') }}" class="admin-btn info">← Назад</a>

<style>
    .archived-row { background: #fff3e0; }
</style>
@endsection