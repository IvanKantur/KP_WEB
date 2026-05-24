@extends('main')

@section('title', 'Новости и акции')

@section('content')
<h2>Новости и акции</h2>

<div class="news-list">
    <article class="news-item">
        <h3><a href="#">Скидки на видеокарты до 20%</a></h3>
        <p class="news-date">15.05.2025</p>
        <p>Только до конца месяца скидки на все видеокарты NVIDIA и AMD...</p>
    </article>

    <article class="news-item">
        <h3><a href="#">Поступление новых процессоров Intel</a></h3>
        <p class="news-date">10.05.2025</p>
        <p>В продажу поступили процессоры Intel Core 14-го поколения...</p>
    </article>

    <article class="news-item">
        <h3><a href="#">График работы в праздничные дни</a></h3>
        <p class="news-date">01.05.2025</p>
        <p>Уважаемые клиенты, ознакомьтесь с графиком работы магазина...</p>
    </article>
</div>

<p class="note">* Управление новостями через админ-панель будет добавлено позже.</p>
@endsection