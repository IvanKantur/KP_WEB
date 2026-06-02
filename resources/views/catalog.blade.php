@extends('main')

@section('title', 'Каталог')

@section('content')
<!-- DEBUG: Шаблон загружен, переменная categories = {{ isset($categories) ? 'передана' : 'НЕ ПЕРЕДАНА' }} -->

<h2>Каталог товаров</h2>

@if(isset($categories) && $categories->count() > 0)
    <div class="categories-grid">
        @foreach($categories as $category)
        <div class="category-card">
            <a href="{{ url('/catalog/' . $category->slug) }}">
                <h3>{{ $category->name }}</h3>
                <p>{{ $category->description ?? 'Перейти в раздел...' }}</p>
            </a>
        </div>
        @endforeach
    </div>
@else
    <p>Категории пока не добавлены.</p>
    <p>Debug: переменная categories {{ isset($categories) ? 'существует, count=' . $categories->count() : 'НЕ СУЩЕСТВУЕТ' }}</p>
@endif

<p class="note">* Выберите категорию для просмотра товаров.</p>
@endsection