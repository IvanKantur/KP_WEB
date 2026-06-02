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
<form id="contact-form" method="POST" action="{{ route('contacts.send') }}" class="contact-form">
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

<!-- Модальное окно -->
<div id="success-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="modal-icon">✅</span>
            <h3>Сообщение отправлено!</h3>
        </div>
        <div class="modal-body">
            <p>Спасибо за ваше сообщение!</p>
            <p>Мы свяжемся с вами в ближайшее время.</p>
        </div>
        <div class="modal-footer">
            <button id="modal-close" class="btn-modal btn-modal-close">Хорошо</button>
        </div>
    </div>
</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script>
    // Яндекс карта
    ymaps.ready(init);
    
    function init() {
        var officeCoords = [44.6110, 33.5262];
        var map = new ymaps.Map("map", {
            center: officeCoords,
            zoom: 17,
            controls: ['zoomControl', 'fullscreenControl']
        });
        var placemark = new ymaps.Placemark(officeCoords, {
            hintContent: 'TechStore',
            balloonContent: '<strong>TechStore</strong><br>г. Севастополь<br>ул. Большая Морская, д. 21<br>☎ +7 (978) 123-45-67'
        }, {
            preset: 'islands#blueStoreIcon',
            balloonCloseButton: true
        });
        map.geoObjects.add(placemark);
    }

    // AJAX отправка формы с модальным окном
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Data:', data);
            if (data.success) {
                document.getElementById('success-modal').classList.add('show');
                document.getElementById('contact-form').reset();
            } else {
                alert('Ошибка: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ошибка: ' + error.message);
        });
    });

    // Закрытие модального окна
    document.getElementById('modal-close').addEventListener('click', function() {
        document.getElementById('success-modal').classList.remove('show');
    });
    
    // Закрытие по клику вне окна
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('success-modal');
        if (e.target === modal) {
            modal.classList.remove('show');
        }
    });
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

/* Модальное окно */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}
.modal.show {
    display: flex;
}
.modal-content {
    background: var(--white);
    border-radius: 20px;
    width: 90%;
    max-width: 400px;
    overflow: hidden;
    animation: modalSlideIn 0.3s ease;
}
@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
.modal-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    padding: 25px;
    text-align: center;
}
.modal-icon {
    font-size: 64px;
    display: block;
    margin-bottom: 10px;
}
.modal-header h3 {
    color: var(--white);
    margin: 0;
    font-size: 1.5rem;
}
.modal-body {
    padding: 30px 20px;
    text-align: center;
}
.modal-body p {
    margin: 10px 0;
    color: var(--gray-dark);
    font-size: 1rem;
}
.modal-footer {
    padding: 20px;
    text-align: center;
    border-top: 1px solid var(--gray-border);
}
.btn-modal {
    padding: 10px 30px;
    border: none;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-modal-close {
    background: var(--blue-dark);
    color: var(--white);
}
.btn-modal-close:hover {
    background: var(--blue-light);
    color: var(--black);
}
</style>
@endsection