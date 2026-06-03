@extends('main')

@section('content')
<h2>{{ $category->name }}</h2>

<div class="products-grid">
    @foreach($products as $product)
    <a href="{{ url('/catalog/' . $category->slug . '/' . $product->slug) }}" class="product-card-link">
        <div class="product-card">
            <div class="product-image">
                @if($product->thumb)
                    <img src="{{ asset('storage/' . $product->thumb) }}" alt="{{ $product->name }}" class="product-thumb">
                @else
                    <span class="no-image">📷</span>
                @endif
            </div>
            <div class="product-title">{{ $product->name }}</div>
            <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
        </div>
    </a>
    @endforeach
</div>

@if($products->isEmpty())
    <p>В этой категории пока нет товаров.</p>
@endif

<a href="{{ url('/catalog') }}" class="back-link">← Назад к категориям</a>

<style>
.product-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}
.product-card-link:hover .product-card {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.product-card {
    transition: all 0.3s ease;
    height: 100%;
}

/* Миниатюры товаров в каталоге */
.product-thumb {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.product-card:hover .product-thumb {
    transform: scale(1.05);
}

.no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 160px;
    background: #f5f5f5;
    color: #ccc;
    font-size: 32px;
    border-radius: 8px;
}
</style>
@endsection