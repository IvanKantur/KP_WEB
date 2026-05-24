@extends('main')

@section('title', 'Техническая поддержка')

@section('content')
<h2>Техническая поддержка</h2>
<p>Возникли проблемы с техникой? Оставьте заявку, и мы свяжемся с вами.</p>

<form action="#" method="POST" class="support-form">
    @csrf
    <div class="form-group">
        <label for="name">Ваше имя: <span class="required">*</span></label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="phone">Телефон: <span class="required">*</span></label>
        <input type="tel" id="phone" name="phone" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="message">Опишите проблему: <span class="required">*</span></label>
        <textarea id="message" name="message" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn">Отправить</button>
</form>

<p class="note">* Поля, отмеченные звездочкой, обязательны для заполнения.</p>
<p class="note">** В финальной версии форма будет отправлять данные на email администратора.</p>
@endsection