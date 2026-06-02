<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - @yield('title', 'Интернет-магазин компьютерной техники')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ url('/css/style.css') }}"> //для опубликованной
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <div class="container">
            <div style="position: relative;">
                <div style="text-align: center;">
                    <h1>TechStore</h1>
                    <p>Компьютерная техника и комплектующие</p>
                </div>
                <div class="auth-links-absolute">
                    @guest
                        <a href="{{ route('login') }}">Вход</a>
                        <a href="{{ route('register') }}">Регистрация</a>
                    @else
                        <span>Привет, {{ Auth::user()->name }}</span>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.index') }}">Админка</a>
                        @endif
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Выход
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <nav>
        <div class="container">
            <a href="{{ url('/') }}">Главная</a>
            <a href="{{ url('/catalog') }}">Каталог</a>
            <a href="{{ url('/news') }}">Новости</a>
            <a href="{{ url('/services') }}">Услуги</a>
            <a href="{{ url('/support') }}">Техподдержка</a>
            <a href="{{ url('/about') }}">О компании</a>
            <a href="{{ url('/contacts') }}">Контакты</a>
            <a href="{{ url('/cart') }}" class="cart-link" id="cart-link">
                🛒 Корзина
                <span class="cart-count" id="cart-count" style="display: none;">0</span>
            </a>
        </div>
    </nav>

    <!-- Уведомление о добавлении в корзину -->
    <div id="cart-notification" class="cart-notification">
        <span class="notification-icon">✅</span>
        <span class="notification-text">Товар добавлен в корзину</span>
    </div>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} TechStore. Все права защищены.</p>
            <p>г. Севастополь</p>
        </div>
    </footer>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Функция обновления счетчика корзины
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById('cart-count');
                if (data.count > 0) {
                    countElement.textContent = data.count;
                    countElement.style.display = 'inline-flex';
                } else {
                    countElement.style.display = 'none';
                }
            })
            .catch(error => console.error('Ошибка:', error));
    }

    // Функция показа уведомления
    function showNotification() {
        const notification = document.getElementById('cart-notification');
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 2000);
    }

    // Делегирование событий для форм добавления в корзину
    document.body.addEventListener('submit', function(e) {
        const form = e.target.closest('.add-to-cart-form');
        if (form) {
            e.preventDefault();
            console.log('Форма отправлена');
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Ответ:', data);
                if (data.success) {
                    updateCartCount();
                    showNotification();
                }
            })
            .catch(error => console.error('Ошибка:', error));
        }
    });

    // Загружаем счетчик при загрузке страницы
    updateCartCount();
});
</script>
</body>
</html>