@extends('main')

@section('title', 'Управление пользователями')

@section('content')
<h2>Управление пользователями</h2>

<div class="admin-buttons">
    <a href="{{ route('admin.users.create') }}" class="admin-btn">➕ Добавить пользователя</a>
    <a href="{{ route('admin.index') }}" class="admin-btn info">← Назад</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Заказов</th>
            <th>Дата регистрации</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->is_admin)
                    <span style="color: #fd7e14;">👑 Администратор</span>
                @else
                    <span style="color: green;">👤 Пользователь</span>
                @endif
            </td>
            <td>{{ $user->orders_count ?? 0 }}</td>
            <td>{{ $user->created_at->format('d.m.Y') }}</td>
            <td style="white-space: nowrap;">
                <a href="{{ route('admin.users.show', $user->id) }}" title="Просмотр">👁️</a>
                <a href="{{ route('admin.users.edit', $user->id) }}" title="Редактировать">✏️</a>
                
                @if(!$user->is_admin)
                    <form action="{{ route('admin.users.make-admin', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" title="Сделать администратором" style="background:none; border:none; cursor:pointer; color:#fd7e14;">👑</button>
                    </form>
                @else
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.remove-admin', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" onclick="return confirm('Снять права администратора?')" title="Снять права" style="background:none; border:none; cursor:pointer; color:orange;">⬇️👑</button>
                        </form>
                    @endif
                @endif
                
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить пользователя?')" title="Удалить" style="background:none; border:none; cursor:pointer; color:red;">🗑️</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
\\</table>

{{ $users->links() }}

<style>
    .alert-error {
        background: #f8d7da;
        color: #721c24;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #dc3545;
    }
    .admin-table td {
        vertical-align: middle;
    }
</style>
@endsection