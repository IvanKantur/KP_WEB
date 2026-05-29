<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - @yield('title', 'Интернет-магазин компьютерной техники')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
            <a href="{{ url('/cart') }}">Корзина 🛒</a>
        </div>
    </nav>

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
</body>
</html>