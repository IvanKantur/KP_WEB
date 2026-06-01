@extends('main')

@section('title', $news->title)

@section('content')
<article class="news-article">
    <h2>{{ $news->title }}</h2>
    
    <div class="news-meta">
        <span class="news-date">📅 {{ $news->published_at ? $news->published_at->format('d.m.Y') : 'Дата не указана' }}</span>
    </div>
    
    @if($news->image)
        <div class="news-image">
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
        </div>
    @endif
    
    <div class="news-content">
        {!! nl2br(e($news->content)) !!}
    </div>
</article>

<a href="{{ route('news') }}" class="back-link">← Назад к списку новостей</a>

<style>
    .news-article {
        max-width: 800px;
        margin: 0 auto;
    }
    .news-article h2 {
        margin-bottom: 15px;
        color: var(--black);
    }
    .news-meta {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--gray-border);
    }
    .news-date {
        color: var(--gray-text);
        font-size: 14px;
    }
    .news-image {
        margin: 25px 0;
        text-align: center;
    }
    .news-image img {
        max-width: 100%;
        border-radius: 12px;
    }
    .news-content {
        line-height: 1.8;
        font-size: 1.05rem;
        color: var(--gray-dark);
    }
    .news-content p {
        margin-bottom: 20px;
    }
    .back-link {
        display: inline-block;
        margin-top: 40px;
        color: var(--blue-dark);
        text-decoration: none;
    }
    .back-link:hover {
        text-decoration: underline;
    }
</style>
@endsection