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
    <section class="bg-stone-50 px-6 py-24 sm:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="panel-card mb-10">
                <div class="gap-6 md:flex md:items-end md:justify-between">
                    <div>
                        <span class="section-label">Writing</span>
                        <h1 class="section-heading">Thoughts on code, design and the web.</h1>
                        <p class="max-w-2xl text-stone-600">A quiet collection of notes, projects and technical ideas.</p>
                    </div>

                    <form method="GET" action="{{ route('blog') }}" class="mt-4 shrink-0 md:mt-0">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="relative">
                            <input type="search" name="search" value="{{ $search }}" placeholder="Search posts..."
                                class="w-72 rounded-full border border-stone-200 bg-white px-4 py-3 pr-10 text-sm text-stone-700 placeholder-stone-400 transition-colors focus:border-stone-400 focus:outline-none">
                            <button type="submit" aria-label="Search posts"
                                class="absolute top-1/2 right-3 -translate-y-1/2 text-stone-400 transition-colors hover:text-stone-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
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
                <div class="mb-8 flex flex-wrap gap-2">
                    <a href="{{ route('blog', $search ? ['search' => $search] : []) }}"
                        class="rounded-full px-3 py-1 text-xs font-semibold tracking-wide uppercase transition-colors {{ !$activeCategory ? 'bg-stone-900 text-white' : 'text-stone-600 border border-stone-200 hover:border-stone-300 hover:text-stone-900' }}">
                        All
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog', array_filter(['category' => $cat->slug, 'search' => $search])) }}"
                            class="rounded-full px-3 py-1 text-xs font-semibold tracking-wide uppercase transition-colors {{ $activeCategory?->is($cat) ? 'bg-stone-900 text-white' : 'text-stone-600 border border-stone-200 hover:border-stone-300 hover:text-stone-900' }}">
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
                <div class="divide-y divide-stone-200 rounded-3xl border border-stone-200 bg-white">
                    @foreach($posts as $post)
                        <article class="p-8">
                            <div class="mb-4 gap-6 md:flex md:items-start md:justify-between">
                                <div>
                                    <a href="{{ route('posts.show', $post->slug) }}" class="group">
                                        <h2 class="group-hover:text-brand text-2xl font-semibold text-stone-900 transition-colors">
                                            {{ $post->title }}
                                        </h2>
                                    </a>
                                    <p class="mt-3 text-sm leading-relaxed text-stone-500">
                                        {!! $post->excerpt ?? Str::limit(strip_tags($post->content), 140) !!}
                                    </p>
                                </div>
                                @if(auth()->user()->role('admin'))
                                    <div class="mt-4 flex items-center gap-3 md:mt-0">
                                        <img src="https://s3.eu-north-1.amazonaws.com/kazazis.dev/profile-pic.png" alt="Kostas"
                                            class="h-10 w-10 rounded-full bg-stone-100 object-cover">
                                        <div class="text-xs font-semibold tracking-[0.25em] text-stone-500 uppercase">Kostas</div>
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
                                    class="text-brand hover:text-brand-dark ml-auto font-semibold transition-colors">
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