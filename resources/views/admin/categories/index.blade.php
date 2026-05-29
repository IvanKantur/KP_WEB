@extends('main')

@section('title', 'Управление категориями')

@section('content')
<h2>Управление категориями</h2>

<!-- Красивые кнопки в одну строку -->
<div class="admin-buttons">
    <a href="{{ route('admin.categories') }}" class="admin-btn info">
        📋 Все категории
    </a>
    <a href="{{ route('admin.categories.active') }}" class="admin-btn success">
        ✓ Активные
    </a>
    <a href="{{ route('admin.categories.archived') }}" class="admin-btn warning">
        📦 В архиве
    </a>
    <a href="{{ route('admin.categories.create') }}" class="admin-btn">
        ➕ Добавить категорию
    </a>
</div>

<!-- Сообщение об успехе -->
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Таблица категорий -->
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Slug</th>
            <th>Порядок</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr class="{{ $category->trashed() ? 'archived-row' : '' }}">
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->sort_order }}</td>
            <td>
                @if($category->trashed())
                    <span class="status-archived">📦 В архиве</span>
                @else
                    <span class="status-active">✓ Активна</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="action-btn" title="Редактировать">✏️</a>
                
                @if($category->trashed())
                    <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="action-btn" title="Восстановить" style="color: #28a745;">🔄</button>
                    </form>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn" onclick="return confirm('Удалить категорию навсегда?')" title="Удалить полностью" style="color: #dc3545;">💀</button>
                    </form>
                @else
                    <form action="{{ route('admin.categories.archive', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn" onclick="return confirm('Отправить в архив?')" title="В архив" style="color: #fd7e14;">📦</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">Категорий не найдено</td>
        </tr>
        @endforelse
    </tbody>
\\</table>

<a href="{{ route('admin.index') }}" class="admin-btn info" style="display: inline-block;">← Назад в админку</a>

<!-- Дополнительные стили -->
<style>
    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #28a745;
    }
    
    .archived-row {
        background: #fff3e0;
        opacity: 0.85;
    }
    
    .status-active {
        color: #28a745;
        font-weight: bold;
    }
    
    .status-archived {
        color: #fd7e14;
        font-weight: bold;
    }
    
    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0 5px;
        text-decoration: none;
        display: inline-block;
    }
    
    .action-btn:hover {
        opacity: 0.7;
        transform: scale(1.1);
    }
</style>
@endsection