@extends('main')

@section('title', 'Контакты')

@section('content')
<h2>Контакты</h2>

<div class="contacts-info">
    <p><strong>📍 Адрес:</strong> г. Севастополь, ул. Большая Морская, д. 21</p>
    <p><strong>📞 Телефон:</strong> +7 (978) 123-45-67</p>
    <p><strong>✉ Email:</strong> info@techstore.ru</p>
    <p><strong>🕒 Режим работы:</strong> Пн-Пт: 10:00-19:00, Сб: 11:00-16:00, Вс: выходной</p>
</div>

<h3>Схема проезда</h3>
<div id="map" style="width: 100%; height: 400px; border-radius: 12px; margin-bottom: 30px;"></div>

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

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script>
    ymaps.ready(init);
    
    function init() {
        // Координаты офиса (Севастополь, ул. Большая Морская, 41)
        var officeCoords = [44.6110, 33.5262];
        // Создаем карту
        var map = new ymaps.Map("map", {
            center: officeCoords,
            zoom: 17,
            controls: ['zoomControl', 'fullscreenControl']
        });
        
        // Добавляем метку
        var placemark = new ymaps.Placemark(officeCoords, {
            hintContent: 'TechStore',
            balloonContent: '<strong>TechStore</strong><br>г. Севастополь<br>ул. Большая Морская, д. 41<br>☎ +7 (978) 123-45-67'
        }, {
            preset: 'islands#blueStoreIcon',
            balloonCloseButton: true
        });
        
        map.geoObjects.add(placemark);
    }
</script>

<style>
.contacts-info {
    background: var(--gray-light);
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 30px;
}
.contacts-info p {
    margin: 10px 0;
}
</style>
@endsection