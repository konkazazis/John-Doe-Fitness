@props([
    "posts",
])

@if ($posts->isNotEmpty())
    <section id="blog" class="py-24 px-6 sm:px-8 bg-stone-50">
        <div class="max-w-6xl mx-auto">
            <div class="max-w-2xl mx-auto text-center mb-16">
                <span class="section-label justify-center">Writing</span>
                <h2 class="section-heading">Latest essays</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-16">
                @foreach ($posts->take(3) as $post)
                    <article class="panel-card flex flex-col">
                        @if ($post->category)
                            <span class="tag-badge self-start">
                                {{ $post->category->name }}
                            </span>
                        @endif

                        <h3
                            class="font-display text-2xl font-bold text-stone-900 mt-4 mb-2"
                        >
                            <a
                                href="{{ route("posts.show", $post->slug) }}"
                                class="hover:text-[#eb5424] transition-colors"
                            >
                                {{ $post->title }}
                            </a>
                        </h3>

                        @if ($post->excerpt)
                            <p class="text-stone-600 text-sm mb-5 flex-1">
                                {!! Str::limit($post->excerpt, 150) !!}
                            </p>
                        @endif

                        <a
                            href="{{ route("posts.show", $post->slug) }}"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold text-stone-900 hover:text-[#eb5424] transition-colors"
                        >
                            Read more
                            <svg
                                class="w-3.5 h-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </a>
                    </article>
                @endforeach
            </div>

            <div class="text-center">
                <a
                    href="{{ route("blog") }}"
                    class="inline-flex items-center justify-center rounded-full border border-stone-300 px-7 py-3 text-sm font-semibold text-stone-800 hover:border-stone-400 hover:bg-white transition-colors"
                >
                    View all essays
                </a>
            </div>
        </div>
    </section>
@endif
