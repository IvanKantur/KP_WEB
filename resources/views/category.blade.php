@extends('main')

@section('content')
<h2>{{ $category->name }}</h2>

<div class="products-grid">
    @foreach($products as $product)
    <div class="product-card">
        <div class="product-image">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <span>📷 Нет фото</span>
            @endif
        </div>
        <div class="product-title">{{ $product->name }}</div>
        <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
        <a href="{{ url('/catalog/' . $category->slug . '/' . $product->slug) }}">
            <button class="btn-buy">Подробнее</button>
        </a>
    </div>
    @endforeach
</div>

@if($products->isEmpty())
    <p>В этой категории пока нет товаров.</p>
@endif

<a href="{{ url('/catalog') }}" class="back-link">← Назад к категориям</a>
@endsection