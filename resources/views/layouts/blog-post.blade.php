@extends('layouts.master')

@section('title', $post->title . ' · John')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?? $post->content), 160))
@section('og_type', 'article')
@section('og_title', $post->title)
@section('canonical', route('posts.show', $post->slug))
@section('og_image', asset('images/home-bg.jpg'))

@push('head')
    @vite('resources/js/syntax-highlight.js')
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
                'name' => 'John Doe',
                'url' => route('home').'#about',
            ],
            'publisher' => [
                $ldType => 'Person',
                'name' => 'John Doe',
            ],
            'keywords' => $post->tags->pluck('name')->join(', '),
            'articleSection' => $post->category?->name,
            'wordCount' => str_word_count(strip_tags($post->content)),
            'image' => asset('images/home-bg.jpg'),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    <div class="mx-auto mt-8 max-w-2xl">

        <a href="{{ route('blog') }}"
            class="text-brand hover:text-brand-dark mb-8 inline-block text-sm font-semibold transition-colors">
            &larr; Back to blog
        </a>

        <header class="mb-10">
            <div class="mb-4 flex items-center gap-3 text-xs">
                @if($post->category)
                    <span class="category-badge">{{ $post->category->name }}</span>
                @endif
                <span class="text-stone-400">{{ $post->published_at->format('M d, Y') }}</span>
            </div>

            <h1 class="mb-4 text-4xl leading-tight font-bold tracking-tight text-stone-900 max-sm:text-3xl">
                {{ $post->title }}
            </h1>

            @if($post->excerpt)
                <p class="text-lg leading-relaxed text-stone-500">{!! $post->excerpt !!}</p>
            @endif

            @if($post->tags->isNotEmpty())
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <span class="tag-badge">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </header>

        @if(auth()->user()->role('admin'))
            <div class="mb-10 flex items-center gap-3 border-b border-stone-100 pb-8">
                <img src="https://s3.eu-north-1.amazonaws.com/kazazis.dev/profile-pic.png" alt="John Doe"
                    class="h-10 w-10 rounded-full bg-stone-100 object-cover object-top">
                <div>
                    <p class="text-sm font-semibold text-stone-800">Konstantinos Kazazis</p>
                    <a href="{{ route('home') }}#about" rel="author"
                        class="hover:text-brand text-xs text-stone-400 transition-colors">
                        Personal Trainer &amp; Nutrition Coach
                    </a>
                </div>
            </div>
        @endif

        <div class="prose prose-stone max-w-none leading-relaxed text-stone-700">
            {!! $post->content !!}
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => hljs.highlightAll());
    </script>
@endpush