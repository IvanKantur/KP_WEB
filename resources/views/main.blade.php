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
            <h1>TechStore</h1>
            <p>Компьютерная техника и комплектующие</p>
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