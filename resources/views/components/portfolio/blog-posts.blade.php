@props(['posts'])

@if($posts->isNotEmpty())
<section id="blog" class="py-24 px-6 sm:px-8 bg-white border-t border-stone-300">
    <div class="max-w-5xl mx-auto">
        <h2 class="font-serif text-5xl md:text-6xl font-bold text-stone-900 mb-20 text-center">
            Latest Essays
        </h2>

        <div class="space-y-12 mb-16">
            @foreach($posts->take(3) as $post)
                <article class="border-b border-stone-300 pb-12">
                    @if($post->category)
                        <span class="text-xs font-medium text-stone-600 uppercase tracking-widest">
                            {{ $post->category->name }}
                        </span>
                    @endif
                    <h3 class="font-serif text-3xl font-bold text-stone-900 my-3 hover:text-stone-700 transition">
                        <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    @if($post->excerpt)
                        <p class="text-stone-600 leading-relaxed font-light mb-4">{!! Str::limit($post->excerpt, 150) !!}</p>
                    @endif
                    <a href="{{ route('posts.show', $post->slug) }}"
                        class="text-sm font-medium text-stone-900 border-b border-stone-400 hover:border-stone-900 transition">
                        Read More
                    </a>
                </article>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('blog') }}"
                class="inline-block text-sm font-medium text-stone-900 border border-stone-400 px-6 py-2 hover:bg-stone-50 transition tracking-wide">
                VIEW ALL ESSAYS
            </a>
        </div>
    </div>
</section>
@endif
