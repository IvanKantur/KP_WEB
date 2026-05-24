@extends('main')

@section('title', 'Контакты')

@section('content')
<h2>Контакты</h2>

<div class="contacts-info">
    <p><strong>Адрес:</strong> г. Севастополь, ул. Университетская , д. 100000</p>
    <p><strong>Телефон:</strong> +7 (978) 123-45-67</p>
    <p><strong>Email:</strong> info@techstore.ru</p>
    <p><strong>Режим работы:</strong> Пн-Пт: 10:00-19:00, Сб: 11:00-16:00, Вс: выходной</p>
</div>

<h3>Схема проезда</h3>
<div class="map-placeholder">
    <p>Здесь будет карта проезда (Google/Яндекс карты)</p>
    <p class="note">(будет добавлено позже)</p>
</div>

<h3>Форма обратной связи</h3>
<form action="#" method="POST" class="contact-form">
    @csrf
    <div class="form-group">
        <label for="name">Ваше имя: <span class="required">*</span></label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email: <span class="required">*</span></label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="message">Сообщение: <span class="required">*</span></label>
        <textarea id="message" name="message" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn">Отправить</button>
</form>
@endsection