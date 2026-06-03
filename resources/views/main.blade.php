<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - @yield('title', 'Интернет-магазин компьютерной техники')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <link rel="stylesheet" href="https://kp-web-uw28.onrender.com/css/style.css"> --}}
    {{-- <link rel="stylesheet" href="{{ url('/css/style.css') }}">  --}}
    {{-- для опубликованной --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(request()->routeIs('admin.news.*') || request()->routeIs('admin.products.*'))
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '.editor',
                height: 400,
                menubar: false,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                language: 'ru',
                images_upload_url: '/upload/image',
                automatic_uploads: false
            });
        </script>
    @endif
</head>
<style>
/* Корпоративные цвета TechStore */
:root {
    --white: #ffffff;
    --black: #1a1a2e;
    --blue-light: #00b4d8;
    --blue-dark: #0f3460;
    --blue-gray: #16213e;
    --blue-hover: #0f3460;
    --gray-bg: #f4f4f4;
    --gray-light: #f9f9f9;
    --gray-border: #e0e0e0;
    --gray-text: #888;
    --gray-dark: #333;
    --red-error: #e74c3c;
}

/* Основные стили */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--gray-bg);
    color: var(--gray-dark);
    line-height: 1.6;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.container {
    width: 1024px;
    max-width: 95%;
    margin: 0 auto;
    padding: 0 15px;
}

/* Шапка */
header {
    background: var(--black);
    color: var(--white);
    padding: 20px 0;
}

header .container {
    position: relative;
}

header h1 {
    font-size: 2rem;
    margin-bottom: 5px;
    text-align: center;
}

header p {
    color: var(--gray-border);
    text-align: center;
}

/* Блок авторизации - position absolute */
.auth-links-absolute {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    display: flex;
    gap: 15px;
    align-items: center;
}

.auth-links-absolute a, 
.auth-links-absolute span {
    color: var(--white);
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    transition: 0.3s;
    font-size: 14px;
}

.auth-links-absolute a:hover {
    background: var(--blue-dark);
}

.auth-links-absolute span {
    background: var(--blue-dark);
}

/* Меню */
nav {
    background: var(--blue-gray);
    position: sticky;
    top: 0;
}

nav .container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

nav a {
    color: var(--white);
    text-decoration: none;
    padding: 12px 20px;
    display: inline-block;
    transition: 0.3s;
}

nav a:hover {
    background: var(--blue-dark);
    border-radius: 5px;
}

/* Корзина в меню */
.cart-link {
    position: relative;
    display: inline-block;
}

.cart-count {
    position: absolute;
    top: 5px;
    right: -8px;
    background: #dc3545;
    color: white;
    font-size: 11px;
    font-weight: bold;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

/* Уведомление о добавлении в корзину */
.cart-notification {
    position: fixed;
    top: 100px;
    right: 20px;
    background: #28a745;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 9999;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    font-size: 14px;
}

.cart-notification.show {
    opacity: 1;
    transform: translateX(0);
}

.notification-icon {
    font-size: 18px;
}

.notification-text {
    font-size: 14px;
}

/* Основной блок */
main {
    min-height: 500px;
    padding: 30px 0;
    background: var(--white);
    flex: 1;
}

/* Заголовки */
h2 {
    color: var(--black);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--blue-dark);
}

h3 {
    color: var(--blue-gray);
    margin: 20px 0 10px 0;
}

/* Блок приветствия */
.welcome {
    background: #e8f4f8;
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 25px;
    text-align: center;
    border-left: 4px solid var(--blue-dark);
}

.welcome h2 {
    border-bottom: none;
    margin-bottom: 10px;
}

/* Заглушки */
.slider-placeholder,
.products-placeholder,
.map-placeholder {
    background: var(--gray-light);
    padding: 40px;
    text-align: center;
    border-radius: 10px;
    margin: 20px 0;
    border: 1px dashed var(--gray-border);
}

/* Блок новостей на главной */
.news-preview {
    background: var(--gray-light);
    padding: 20px;
    border-radius: 10px;
    margin-top: 25px;
}

.news-preview ul {
    list-style: none;
    margin: 15px 0;
}

.news-preview li {
    padding: 10px 0;
    border-bottom: 1px solid var(--gray-border);
}

.news-preview li a {
    color: var(--black);
    text-decoration: none;
}

.news-preview li a:hover {
    color: var(--blue-dark);
}

.news-preview li span {
    float: right;
    color: var(--gray-text);
    font-size: 12px;
}

.more-link {
    display: inline-block;
    margin-top: 10px;
    color: var(--blue-dark);
    text-decoration: none;
}

/* Страница новостей */
.news-item {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--gray-border);
}

.news-item h3 a {
    color: var(--black);
    text-decoration: none;
}

.news-date {
    color: var(--gray-text);
    font-size: 12px;
    margin-bottom: 10px;
}

/* Сетка товаров */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.product-card {
    border: 1px solid var(--gray-border);
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    background: var(--white);
    transition: 0.3s;
}

.product-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-3px);
    border-color: var(--blue-hover);
}

.product-image {
    width: 100%;
    height: 160px;
    background: #f0f0f0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    margin-bottom: 15px;
}

.product-title {
    font-size: 1rem;
    font-weight: bold;
    margin: 10px 0;
}

.product-price {
    color: var(--blue-dark);
    font-size: 1.2rem;
    font-weight: bold;
    margin: 10px 0;
}

.btn-buy {
    background: var(--black);
    color: var(--white);
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-buy:hover {
    background: var(--blue-dark);
}

/* Список услуг */
.services-list {
    list-style: none;
}

.services-list li {
    background: var(--gray-light);
    margin: 15px 0;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid var(--blue-dark);
}

/* Формы */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: inline-block;
    width: 200px;
    font-weight: bold;
}

.form-group input,
.form-group textarea,
.form-group select {
    padding: 8px 12px;
    width: 300px;
    border: 1px solid var(--gray-border);
    border-radius: 5px;
}

.required {
    color: var(--red-error);
}

.btn {
    background: var(--black);
    color: var(--white);
    padding: 10px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: var(--blue-dark);
}

/* Контакты */
.contacts-info {
    background: var(--gray-light);
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

/* Подвал */
footer {
    background: var(--black);
    color: var(--gray-text);
    text-align: center;
    padding: 20px 0;
    margin-top: 30px;
}

/* Примечания */
.note {
    font-size: 12px;
    color: var(--gray-text);
    margin-top: 10px;
    font-style: italic;
}

/* Сетка категорий */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.category-card {
    background: var(--gray-light);
    border: 1px solid var(--gray-border);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    transition: 0.3s;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    background-color: var(--blue-hover);
}

.category-card:hover a {
    color: var(--white);
}

.category-card:hover h3 {
    color: var(--white);
}

.category-card a {
    text-decoration: none;
    color: var(--gray-dark);
}

.category-card h3 {
    color: var(--black);
    margin-bottom: 10px;
}

/* Детальная страница товара */
.product-detail {
    display: flex;
    gap: 40px;
    margin: 30px 0;
    flex-wrap: wrap;
}

.product-images {
    flex: 1;
    min-width: 300px;
}

.main-image {
    background: #f0f0f0;
    border-radius: 10px;
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-info {
    flex: 1;
    min-width: 300px;
}

.product-info .product-price {
    font-size: 2rem;
    color: var(--blue-dark);
    margin: 20px 0;
}

.product-stock {
    margin: 15px 0;
}

.product-actions {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--gray-border);
}

.product-actions label {
    margin-right: 10px;
}

.product-actions input {
    width: 80px;
    padding: 8px;
    margin-right: 15px;
}

.add-to-cart {
    padding: 12px 25px;
    font-size: 1rem;
    background: var(--blue-dark);
    color: var(--white);
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: 0.3s;
}

.add-to-cart:hover {
    background: var(--blue-light);
    color: var(--black);
}

.back-link {
    display: inline-block;
    margin-top: 20px;
    color: var(--blue-dark);
    text-decoration: none;
}

.back-link:hover {
    text-decoration: underline;
}

/* Пустая корзина */
.cart-empty {
    text-align: center;
    padding: 60px 20px;
    background: var(--gray-light);
    border-radius: 20px;
    margin: 30px 0;
}

.cart-empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.cart-empty p {
    margin: 15px 0;
    color: #666;
    font-size: 1.1rem;
}

.cart-empty-btn {
    display: inline-block;
    background: var(--blue-dark);
    color: var(--white) !important;
    text-decoration: none;
    padding: 12px 30px;
    border-radius: 30px;
    margin-top: 20px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.cart-empty-btn:hover {
    background: var(--blue-light);
    color: var(--black) !important;
    transform: translateY(-2px);
}

/* Уведомления */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    border-left: 4px solid #28a745;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    border-left: 4px solid #dc3545;
}

/* Админ панель */
.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.stat-card {
    background: var(--gray-light);
    border: 1px solid var(--gray-border);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}

.stat-card h3 {
    margin: 0 0 10px 0;
}

.stat-card p {
    font-size: 2rem;
    font-weight: bold;
    color: var(--blue-dark);
}

.stat-card a {
    display: inline-block;
    margin-top: 10px;
    color: var(--blue-dark);
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.admin-table th,
.admin-table td {
    border: 1px solid var(--gray-border);
    padding: 10px;
    text-align: left;
}

.admin-table th {
    background: var(--blue-gray);
    color: var(--white);
}

.admin-table td form {
    display: inline;
}

.admin-table button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.2rem;
}

small {
    font-size: 11px;
    color: var(--gray-text);
}

/* Кнопки админ панели */
.admin-buttons {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
    flex-wrap: wrap;
    border-bottom: 1px solid var(--gray-border);
    padding-bottom: 15px;
}

.admin-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: var(--blue-dark);
    color: var(--white);
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.admin-btn:hover {
    background: var(--blue-light);
    transform: translateY(-2px);
    color: var(--black);
}

.admin-btn.danger {
    background: #dc3545;
}

.admin-btn.danger:hover {
    background: #c82333;
}

.admin-btn.warning {
    background: #fd7e14;
}

.admin-btn.warning:hover {
    background: #e06b0f;
}

.admin-btn.success {
    background: #28a745;
}

.admin-btn.success:hover {
    background: #218838;
}

.admin-btn.info {
    background: var(--blue-gray);
}

.admin-btn.info:hover {
    background: var(--blue-dark);
}

/* Оформление заказа */
.checkout-layout {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.checkout-products {
    flex: 1;
}

.checkout-form {
    flex: 1;
}

/* Корзина таблица */
.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.cart-table th,
.cart-table td {
    border: 1px solid var(--gray-border);
    padding: 12px;
    text-align: left;
    vertical-align: middle;
}

.cart-table th {
    background: var(--blue-gray);
    color: var(--white);
}

.cart-qty-form {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}

.cart-qty-input {
    width: 70px;
    padding: 6px;
    border: 1px solid var(--gray-border);
    border-radius: 4px;
    text-align: center;
}

.cart-actions {
    display: flex;
    gap: 15px;
    justify-content: space-between;
    margin-top: 20px;
    flex-wrap: wrap;
}

.btn-primary {
    background: #28a745;
}

.btn-primary:hover {
    background: #218838;
}

.btn-small {
    background: var(--blue-dark);
    color: var(--white);
    border: none;
    padding: 6px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 12px;
    transition: 0.3s;
}

.btn-small:hover {
    background: var(--blue-light);
    color: var(--black);
}

.btn-danger {
    background: #dc3545;
}

.btn-danger:hover {
    background: #c82333;
}

/* Адаптация под телефон */
@media (max-width: 768px) {
    .form-group label {
        display: block;
        width: 100%;
        margin-bottom: 5px;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
    }
    
    .btn {
        margin-left: 0;
        width: 100%;
    }
    
    .news-preview li span {
        float: none;
        display: block;
        font-size: 11px;
        margin-top: 5px;
    }
    
    nav a {
        padding: 8px 12px;
        font-size: 12px;
    }

    .auth-links-absolute {
        position: static;
        transform: none;
        justify-content: center;
        margin-top: 10px;
    }

/* Уменьшаем фото в каталоге */
.product-image {
    width: 100%;
    height: 160px;
    overflow: hidden;
    border-radius: 8px;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-image span {
    font-size: 32px;
    color: #ccc;
}
}
</style>
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
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
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
        // fetch('{{ route("cart.count") }}')
        fetch('{{ url("/cart/count") }}')
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