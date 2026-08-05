@props([
    "posts",
])

@if ($posts->isNotEmpty())
    <section id="blog" class="bg-stone-50 px-6 py-24 sm:px-8">
        <div class="mx-auto max-w-6xl">
            <div class="mx-auto mb-16 max-w-2xl text-center">
                <span class="section-label justify-center">Writing</span>
                <h2 class="section-heading">Latest essays</h2>
            </div>

            <div class="mb-16 grid gap-6 md:grid-cols-3">
                @foreach ($posts->take(3) as $post)
                    <article class="panel-card flex flex-col">
                        @if ($post->category)
                            <span class="tag-badge self-start">
                                {{ $post->category->name }}
                            </span>
                        @endif

                        <h3
                            class="font-display mt-4 mb-2 text-2xl text-ink uppercase"
                        >
                            <a
                                href="{{ route("posts.show", $post->slug) }}"
                                class="transition-colors hover:text-brand"
                            >
                                {{ $post->title }}
                            </a>
                        </h3>

                        @if ($post->excerpt)
                            <p class="mb-5 flex-1 text-sm text-ink/60">
                                {!! Str::limit($post->excerpt, 150) !!}
                            </p>
                        @endif

                        <a
                            href="{{ route("posts.show", $post->slug) }}"
                            class="inline-flex items-center gap-1.5 text-sm font-bold text-ink transition-colors hover:text-brand"
                        >
                            Read more
                            <svg
                                class="h-3.5 w-3.5"
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
                    class="inline-flex items-center justify-center rounded-full border-2 border-ink px-7 py-3 text-sm font-bold text-ink transition-colors hover:bg-ink hover:text-white"
                >
                    View all essays
                </a>
            </div>
        </div>
    </section>
@endif
