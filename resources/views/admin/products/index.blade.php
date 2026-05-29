@extends('main')

@section('title', 'Управление товарами')

@section('content')
<h2>Управление товарами</h2>

<!-- Красивые кнопки в одну строку -->
<div class="admin-buttons">
    <a href="{{ route('admin.products') }}" class="admin-btn info">
        📋 Все товары
    </a>
    <a href="{{ route('admin.products.active') }}" class="admin-btn success">
        ✓ Активные
    </a>
    <a href="{{ route('admin.products.archived') }}" class="admin-btn warning">
        📦 В архиве
    </a>
    <a href="{{ route('admin.products.create') }}" class="admin-btn">
        ➕ Добавить товар
    </a>
</div>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Категория</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Остаток</th>
            <th>Активен</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr class="{{ $product->trashed() ? 'archived-row' : '' }}">
            <td>{{ $product->id }}</td>
            <td>{{ $product->category->name ?? '-' }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price, 0, ',', ' ') }} ₽</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->is_active ? '✅ Да' : '❌ Нет' }}</td>
            <td>
                @if($product->trashed())
                    <span class="status-archived">📦 В архиве</span>
                @else
                    <span class="status-active">✓ Активен</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="action-btn" title="Редактировать">✏️</a>
                
                @if($product->trashed())
                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="action-btn" title="Восстановить" style="color: #28a745;">🔄</button>
                    </form>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn" onclick="return confirm('Удалить товар навсегда?')" title="Удалить полностью" style="color: #dc3545;">💀</button>
                    </form>
                @else
                    <form action="{{ route('admin.products.archive', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn" onclick="return confirm('Отправить в архив?')" title="В архив" style="color: #fd7e14;">📦</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align: center;">Товаров не найдено</td>
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