@extends('main')

@section('content')
<div class="product-detail">
    <div class="product-images">
        <div class="main-image">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <span>Нет фото</span>
            @endif
        </div>
    </div>
    
    <div class="product-info">
        <h2>{{ $product->name }}</h2>
        <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
        
        <div class="product-stock">
            @if($product->stock > 0)
                <span style="color: green;">В наличии ({{ $product->stock }} шт.)</span>
            @else
                <span style="color: red;">Нет в наличии</span>
            @endif
        </div>
        
        <div class="product-description">
            <h3>Описание</h3>
            <p>{{ $product->description ?? 'Описание отсутствует.' }}</p>
        </div>
        
        @if($product->specifications)
        <div class="product-specs">
            <h3>Характеристики</h3>
            <p>{{ $product->specifications }}</p>
        </div>
        @endif
        
        <div class="product-actions">
            <label for="quantity">Количество:</label>
            <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" {{ $product->stock > 0 ? '' : 'disabled' }}>
            
            <button class="btn-buy add-to-cart" data-product-id="{{ $product->id }}" {{ $product->stock > 0 ? '' : 'disabled' }}>
                Добавить в корзину
            </button>
        </div>
    </div>
</div>

<a href="{{ url('/catalog/' . $product->category->slug) }}" class="back-link">
    ← Назад к {{ $product->category->name }}
</a>
@endsection