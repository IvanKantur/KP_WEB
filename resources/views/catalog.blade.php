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
@endsection