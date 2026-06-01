@extends('main')

@section('content')
<div class="welcome">
    <h2>Добро пожаловать в TechStore!</h2>
    <p>Ваш надежный поставщик компьютерной техники и комплектующих.</p>
</div>

<div class="featured">
    <h3>⭐ Рекомендуемые товары</h3>
    <div class="products-grid">
        @php
            $featuredProducts = App\Models\Product::where('is_featured', true)
                ->where('is_active', true)
                ->limit(4)
                ->get();
        @endphp
        @foreach($featuredProducts as $product)
        <a href="{{ url('/catalog/' . $product->category->slug . '/' . $product->slug) }}" class="product-card-link">
            <div class="product-card">
                <div class="product-image">
                    @if($product->thumb)
                        <img src="{{ asset('storage/' . $product->thumb) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span>📷 Нет фото</span>
                    @endif
                </div>
                <div class="product-title">{{ $product->name }}</div>
                <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
            </div>
        </a>
        @endforeach
    </div>
</div>

<div class="news-preview">
    <h3>📰 Последние новости</h3>
    @php
        $latestNews = App\Models\News::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();
    @endphp
    <ul>
        @foreach($latestNews as $news)
        <li>
            <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
            <span>{{ $news->published_at ? date('d.m.Y', strtotime($news->published_at)) : '' }}</span>
        </li>
        @endforeach
    </ul>
    <a href="{{ url('/news') }}" class="more-link">Все новости →</a>
</div>

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
</style>
@endsection