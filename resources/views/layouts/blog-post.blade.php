@extends('layouts.master')

@section('title', $post->title . ' · kostas')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?? $post->content), 160))
@section('og_type', 'article')
@section('og_title', $post->title)
@section('canonical', route('posts.show', $post->slug))
@section('og_image', asset('images/home-bg.jpg'))

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/highlight.js@11.9.0/styles/github-dark-dimmed.min.css">
@endpush

@push('schema')
    <script type="application/ld+json">
    @php
        $ldContext = '@context';
        $ldType = '@type';
    @endphp
                {!! json_encode([
        $ldContext => 'https://schema.org',
        $ldType => 'BreadcrumbList',
        'itemListElement' => [
            [$ldType => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            [$ldType => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog')],
            [$ldType => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => route('posts.show', $post->slug)],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
            </script>

    <script type="application/ld+json">
    @php
        $ldContext = '@context';
        $ldType = '@type';
    @endphp
                {!! json_encode([
        $ldContext => 'https://schema.org',
        $ldType => 'BlogPosting',
        'headline' => $post->title,
        'description' => \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?? $post->content), 160),
        'url' => route('posts.show', $post->slug),
        'datePublished' => $post->published_at->toIso8601String(),
        'dateModified' => $post->updated_at->toIso8601String(),
        'author' => [
            $ldType => 'Person',
            'name' => 'Konstantinos Kazazis',
            'url' => route('about'),
        ],
        'publisher' => [
            $ldType => 'Person',
            'name' => 'Konstantinos Kazazis',
        ],
        'keywords' => $post->tags->pluck('name')->join(', '),
        'articleSection' => $post->category?->name,
        'wordCount' => str_word_count(strip_tags($post->content)),
        'image' => asset('images/home-bg.jpg'),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
                </script>
@endpush

@section('content')
    <div class="max-w-2xl mx-auto mt-8">

        <a href="{{ route('blog') }}"
            class="text-sm text-brand hover:text-brand-dark font-semibold transition-colors mb-8 inline-block">
            &larr; Back to blog
        </a>

        <header class="mb-10">
            <div class="flex items-center gap-3 text-xs mb-4">
                @if($post->category)
                    <span class="category-badge">{{ $post->category->name }}</span>
                @endif
                <span class="text-stone-400">{{ $post->published_at->format('M d, Y') }}</span>
            </div>

            <h1 class="text-4xl max-sm:text-3xl font-bold tracking-tight text-stone-900 mb-4 leading-tight">
                {{ $post->title }}
            </h1>

            @if($post->excerpt)
                <p class="text-lg text-stone-500 leading-relaxed">{!! $post->excerpt !!}</p>
            @endif

            @if($post->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach($post->tags as $tag)
                        <span class="tag-badge">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </header>

        @if($post->user?->is_admin)
            <div class="flex items-center gap-3 mb-10 pb-8 border-b border-stone-100">
                <img src="https://s3.eu-north-1.amazonaws.com/kazazis.dev/profile-pic.png" alt="Kostas"
                    class="w-10 h-10 rounded-full object-cover object-top bg-stone-100">
                <div>
                    <p class="text-sm font-semibold text-stone-800">Konstantinos Kazazis</p>
                    <a href="{{ route('about') }}" rel="author"
                        class="text-xs text-stone-400 hover:text-brand transition-colors">
                        Software Developer
                    </a>
                </div>
            </div>
        @endif

        <div class="prose prose-stone max-w-none text-stone-700 leading-relaxed">
            {!! $post->content !!}
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/highlight.js@11.9.0/lib/highlight.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => hljs.highlightAll());
    </script>
@endpush