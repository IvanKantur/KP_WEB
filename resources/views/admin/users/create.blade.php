@extends('main')

@section('title', 'Добавить пользователя')

@section('content')
<h2>Добавление пользователя</h2>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <div class="form-group">
        <label>Имя:</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div class="form-group">
        <label>Пароль:</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Подтверждение пароля:</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_admin" value="1">
            Администратор
        </label>
    </div>
    <button type="submit" class="btn">Создать</button>
</form>

<a href="{{ route('admin.users') }}">← Назад</a>
@endsection