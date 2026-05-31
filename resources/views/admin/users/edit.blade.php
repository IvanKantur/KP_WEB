@extends('main')

@section('title', 'Редактировать пользователя')

@section('content')
<h2>Редактирование пользователя: {{ $user->name }}</h2>

<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Имя:</label>
        <input type="text" name="name" value="{{ $user->name }}" required>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div class="form-group">
        <label>Новый пароль (оставьте пустым, если не меняете):</label>
        <input type="password" name="password">
    </div>
    <div class="form-group">
        <label>Подтверждение пароля:</label>
        <input type="password" name="password_confirmation">
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}>
            Администратор
        </label>
    </div>
    <button type="submit" class="btn">Сохранить</button>
</form>

<a href="{{ route('admin.users') }}">← Назад</a>
@endsection