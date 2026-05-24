@extends('main')

@section('title', 'Главная')

@section('content')
<div class="welcome">
    <h2>Добро пожаловать в TechStore!</h2>
    <p>Ваш надежный поставщик компьютерной техники и комплектующих.</p>
</div>

<div class="slider">
    <h3>Акции</h3>
    <div class="slider-placeholder">
        <p>Здесь будет слайдшоу с акционными товарами</p>
        <p class="note">(будет реализовано в следующих версиях)</p>
    </div>
</div>

<div class="featured">
    <h3>Рекомендуемые товары</h3>
    <div class="products-placeholder">
        <p>Скоро здесь появятся рекомендуемые товары</p>
    </div>
</div>

<div class="news-preview">
    <h3>📰 Последние новости</h3>
    <ul>
        <li><a href="#">Скидки на видеокарты до 20%</a> <span>15.05.2025</span></li>
        <li><a href="#">Поступление новых процессоров Intel</a> <span>10.05.2025</span></li>
        <li><a href="#">График работы в праздничные дни</a> <span>01.05.2025</span></li>
    </ul>
    <a href="{{ url('/news') }}" class="more-link">Все новости →</a>
</div>
@endsection