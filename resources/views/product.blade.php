@extends('main')

@section('content')
<div class="product-detail">
    <div class="product-images">
        <div class="main-image">
            @if($product->images && $product->images->count() > 0)
                <img id="main-product-image" src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}" style="width: 100%; max-width: 400px;">
            @elseif($product->image)
                <img id="main-product-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; max-width: 400px;">
            @else
                <span>📷 Нет фото</span>
            @endif
        </div>
        
        @if($product->images && $product->images->count() > 1)
        <div class="thumbnail-list">
            @foreach($product->images as $img)
            <div class="thumbnail {{ $loop->first ? 'active' : '' }}" data-image="{{ asset('storage/' . $img->image) }}">
                <img src="{{ asset('storage/' . $img->image) }}" alt="thumb">
            </div>
            @endforeach
        </div>
        @endif
    </div>
    
    <div class="product-info">
        <h2>{{ $product->name }}</h2>
        <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
        
        <div class="product-stock">
            @if($product->stock > 0)
                <span style="color: green;">✅ В наличии ({{ $product->stock }} шт.)</span>
            @else
                <span style="color: red;">❌ Нет в наличии</span>
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
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="add-to-cart">
                    🛒 Добавить в корзину
                </button>
            </form>
        </div>
    </div>
</div>

<a href="{{ url('/catalog/' . $product->category->slug) }}" class="back-link">
    ← Назад к {{ $product->category->name }}
</a>

<style>
.thumbnail-list {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    flex-wrap: wrap;
}
.thumbnail {
    width: 60px;
    height: 60px;
    border: 2px solid transparent;
    border-radius: 8px;
    cursor: pointer;
    overflow: hidden;
    transition: all 0.2s;
}
.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.thumbnail:hover {
    transform: scale(1.05);
}
.thumbnail.active {
    border-color: var(--blue-dark);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('main-product-image');
    
    if (thumbnails.length > 0 && mainImage) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const newSrc = this.dataset.image;
                if (newSrc) {
                    mainImage.src = newSrc;
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
    }
});
</script>
@endsection