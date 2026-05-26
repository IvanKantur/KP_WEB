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
        <div class="product-card">
            <div class="product-title">{{ $product->name }}</div>
            <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
            <a href="{{ $product->category ? url('/catalog/' . $product->category->slug . '/' . $product->slug) : '#' }}">
                <button class="btn-buy" {{ !$product->category ? 'disabled' : '' }}>Подробнее</button>
            </a>
        </div>
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
            <a href="#">{{ $news->title }}</a>
            <span>{{ $news->published_at ? date('d.m.Y', strtotime($news->published_at)) : '' }}</span>
        </li>
        @endforeach
    </ul>
    <a href="{{ url('/news') }}" class="more-link">Все новости →</a>
</div>
@endsection