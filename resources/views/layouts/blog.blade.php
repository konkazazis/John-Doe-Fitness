@extends('layouts.master')

@section('title', 'Blog · kostas')
@section('meta_description', 'Thoughts on code, design, and the web — a developer blog by Kostas.')
@section('og_title', 'Blog · kostas')
@section('canonical', $activeCategory ? route('blog', ['category' => $activeCategory->slug]) : route('blog'))

@push('head')
    @if($search)
        <meta name="robots" content="noindex, follow">
    @endif
    @if($posts->previousPageUrl())
        <link rel="prev" href="{{ $posts->previousPageUrl() }}">
    @endif
    @if($posts->nextPageUrl())
        <link rel="next" href="{{ $posts->nextPageUrl() }}">
    @endif
@endpush

@push('schema')
    <script type="application/ld+json">
    @php
        $ldContext = '@context';
        $ldType = '@type';
    @endphp
            {!! json_encode([
        $ldContext => 'https://schema.org',
        $ldType => 'Blog',
        'name' => 'Blog · kostas',
        'description' => 'Thoughts on code, design, and the web — a developer blog by Kostas.',
        'url' => route('blog'),
        'author' => [
            $ldType => 'Person',
            'name' => 'Konstantinos Kazazis',
            'url' => route('about'),
        ],
        'blogPost' => $posts->map(fn($post) => [
            $ldType => 'BlogPosting',
            'headline' => $post->title,
            'url' => route('posts.show', $post->slug),
            'datePublished' => $post->published_at->toIso8601String(),
            'description' => \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?? $post->content), 160),
            'author' => [$ldType => 'Person', 'name' => 'Konstantinos Kazazis', 'url' => route('about')],
        ])->values()->all(),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
@endpush

@section('content')
    <section class="py-24 px-6 sm:px-8 bg-stone-50">
        <div class="max-w-7xl mx-auto">
            <div class="panel-card mb-10">
                <div class="md:flex md:items-end md:justify-between gap-6">
                    <div>
                        <span class="section-label">Writing</span>
                        <h1 class="section-heading">Thoughts on code, design and the web.</h1>
                        <p class="text-stone-600 max-w-2xl">A quiet collection of notes, projects and technical ideas.</p>
                    </div>

                    <form method="GET" action="{{ route('blog') }}" class="shrink-0 mt-4 md:mt-0">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="relative">
                            <input type="search" name="search" value="{{ $search }}" placeholder="Search posts..."
                                class="w-72 rounded-full border border-stone-200 bg-white px-4 py-3 pr-10 text-sm text-stone-700 placeholder-stone-400 focus:outline-none focus:border-stone-400 transition-colors">
                            <button type="submit" aria-label="Search posts"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($categories->isNotEmpty())
                <div class="flex flex-wrap gap-2 mb-8">
                    <a href="{{ route('blog', $search ? ['search' => $search] : []) }}"
                        class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide transition-colors
                            {{ !$activeCategory ? 'bg-stone-900 text-white' : 'text-stone-600 border border-stone-200 hover:border-stone-300 hover:text-stone-900' }}">
                        All
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog', array_filter(['category' => $cat->slug, 'search' => $search])) }}"
                            class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide transition-colors
                                    {{ $activeCategory?->is($cat) ? 'bg-stone-900 text-white' : 'text-stone-600 border border-stone-200 hover:border-stone-300 hover:text-stone-900' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            @if($posts->isEmpty())
                <p class="text-stone-500">
                    No posts found
                    @if($search) for "<span class="text-stone-700">{{ $search }}</span>"@endif
                    @if($activeCategory) in <span class="text-stone-700">{{ $activeCategory->name }}</span>@endif{{-- --}}.
                </p>
            @else
                <div class="divide-y divide-stone-200 bg-white rounded-3xl border border-stone-200">
                    @foreach($posts as $post)
                        <article class="p-8">
                            <div class="md:flex md:items-start md:justify-between gap-6 mb-4">
                                <div>
                                    <a href="{{ route('posts.show', $post->slug) }}" class="group">
                                        <h2 class="text-2xl font-semibold text-stone-900 group-hover:text-brand transition-colors">
                                            {{ $post->title }}
                                        </h2>
                                    </a>
                                    <p class="mt-3 text-sm text-stone-500 leading-relaxed">
                                        {!! $post->excerpt ?? Str::limit(strip_tags($post->content), 140) !!}
                                    </p>
                                </div>
                                @if($post->user?->is_admin)
                                    <div class="mt-4 md:mt-0 flex items-center gap-3">
                                        <img src="https://s3.eu-north-1.amazonaws.com/kazazis.dev/profile-pic.png" alt="Kostas"
                                            class="w-10 h-10 rounded-full object-cover bg-stone-100">
                                        <div class="text-xs text-stone-500 uppercase tracking-[0.25em] font-semibold">Kostas</div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-xs text-stone-500">
                                @if($post->category)
                                    <a href="{{ route('blog', ['category' => $post->category->slug]) }}"
                                        class="category-badge hover:bg-brand-dark">
                                        {{ $post->category->name }}
                                    </a>
                                @endif

                                @foreach($post->tags as $tag)
                                    <span class="tag-badge">#{{ $tag->name }}</span>
                                @endforeach

                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                <a href="{{ route('posts.show', $post->slug) }}"
                                    class="ml-auto text-brand hover:text-brand-dark font-semibold transition-colors">
                                    Read article →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection