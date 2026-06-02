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
    <article class="news-item">
        @if($news->firstImage)
            <img src="{{ asset('storage/' . $news->firstImage->image) }}" alt="{{ $news->title }}" class="news-preview-image">
        @elseif($news->image)
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="news-preview-image">
        @endif
        <h3>
            <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
        </h3>
        <p class="news-date">{{ $news->published_at ? $news->published_at->format('d.m.Y') : '' }}</p>
        <p class="news-announce">{{ $news->announce }}</p>
        <a href="{{ route('news.show', $news->slug) }}" class="more-link">Читать далее →</a>
    </article>
    @endforeach
</div>

{{ $newsList->links() }}

@if($newsList->isEmpty())
    <p>Новостей пока нет.</p>
@endif

<style>
.news-preview-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 15px;
}
</style>
@endsection