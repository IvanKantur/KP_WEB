@extends('main')

@section('title', 'Каталог')

@section('content')
<h2>Каталог товаров</h2>

<div class="categories-grid">
    @foreach($categories as $category)
    <div class="category-card">
        <a href="{{ url('/catalog/' . $category->slug) }}">
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-image">
            @else
                <div class="category-image-placeholder">📁</div>
            @endif
            <h3>{{ $category->name }}</h3>
            <p>{{ $category->description ?? 'Перейти в раздел...' }}</p>
        </a>
    </div>
    @endforeach
</div>
<style>
.category-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
}
.category-image-placeholder {
    width: 100%;
    height: 180px;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    border-radius: 12px;
}
</style>
@endsection