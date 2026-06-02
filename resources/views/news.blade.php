@extends('main')

@section('title', 'Новости и акции')

@section('content')
<h2>Новости и акции</h2>

@php
    $newsList = App\Models\News::where('is_active', true)
        ->orderBy('published_at', 'desc')
        ->paginate(10);
@endphp

<div class="news-list">
    @foreach($newsList as $news)
    <div class="news-item">
        @if($news->firstImage)
            <div class="news-image-wrapper">
                <img src="{{ asset('storage/' . $news->firstImage->image) }}" alt="{{ $news->title }}" class="news-preview-image">
            </div>
        @endif
        <div class="news-content-preview">
            <div class="news-date">{{ $news->published_at ? $news->published_at->format('d.m.Y') : '' }}</div>
            <h3 class="news-title">
                <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
            </h3>
            <p class="news-announce">{{ $news->announce }}</p>
            <a href="{{ route('news.show', $news->slug) }}" class="more-link">Читать далее →</a>
        </div>
    </div>
    @endforeach
</div>

{{ $newsList->links() }}

@if($newsList->isEmpty())
    <p>Новостей пока нет.</p>
@endif

<style>
.news-list {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.news-item {
    display: flex;
    gap: 25px;
    padding-bottom: 25px;
    border-bottom: 1px solid var(--gray-border);
}

.news-image-wrapper {
    flex-shrink: 0;
    width: 260px;
}

.news-preview-image {
    width: 100%;
    height: auto;
    max-height: 160px;
    object-fit: contain;
    border-radius: 12px;
    background: #f5f5f5;
}

.news-content-preview {
    flex: 1;
}

.news-date {
    color: var(--gray-text);
    font-size: 13px;
    margin-bottom: 8px;
}

.news-title {
    margin: 0 0 10px 0;
    font-size: 1.2rem;
}

.news-title a {
    color: var(--black);
    text-decoration: none;
}

.news-title a:hover {
    color: var(--blue-dark);
}

.news-announce {
    color: var(--gray-dark);
    margin-bottom: 12px;
    line-height: 1.5;
}

.more-link {
    color: var(--blue-dark);
    text-decoration: none;
    font-weight: 500;
    display: inline-block;
}

.more-link:hover {
    text-decoration: underline;
}

/* Если нет фото */
.news-item:has(.news-image-wrapper:empty) .news-content-preview {
    margin-left: 0;
}

/* Адаптация для телефонов */
@media (max-width: 768px) {
    .news-item {
        flex-direction: column;
        gap: 15px;
    }
    
    .news-image-wrapper {
        width: 100%;
    }
    
    .news-preview-image {
        height: 180px;
    }
}
</style>
@endsection