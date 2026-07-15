@props([
    "projects",
])

<section id="portfolio" class="bg-white px-6 py-24 sm:px-8">
    <div class="mx-auto max-w-6xl">
        <div class="mx-auto mb-20 max-w-2xl text-center">
            <span class="section-label justify-center">Selected work</span>
            <h2 class="section-heading">Client's stories</h2>
        </div>

        <div class="flex flex-col gap-[clamp(40px,6vw,76px)]">
            @foreach ($projects as $i => $project)
                <article
                    class="reveal grid grid-cols-1 items-center gap-[clamp(28px,4vw,56px)] md:grid-cols-[1.05fr_0.95fr]"
                >
                    <a
                        href="{{ $project->live_url ?? "#" }}"
                        @if($project->live_url) target="_blank" rel="noopener" @endif
                        class="group relative rounded-3xl overflow-hidden border border-stone-200 bg-stone-100 aspect-[16/11] shadow-sm {{ $i % 2 ? "md:order-2" : "" }}"
                    >
                        @if ($project->coverUrl())
                            <img
                                src="{{ $project->coverUrl() }}"
                                alt="{{ $project->title }}"
                                loading="lazy"
                                class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.035]"
                            />
                        @endif

                        <span
                            class="absolute top-3.5 right-3.5 inline-flex -translate-y-1.5 items-center gap-[7px] rounded-full border border-stone-200 bg-white/90 px-3 py-[7px] text-xs font-medium tracking-wide opacity-0 backdrop-blur transition group-hover:translate-y-0 group-hover:opacity-100"
                        >
                            Visit live
                            <span>&#8599;</span>
                        </span>
                    </a>
                    <div>
                        <h3
                            class="font-display mt-3 text-[clamp(1.5rem,3vw,2.1rem)] leading-[1.08] font-bold tracking-tight text-stone-900"
                        >
                            {{ $project->title }}
                        </a>
                    </h3>
                    <p class="mt-3.5 max-w-[44ch] text-stone-600">
                        {{ $project->description }}
                    </p>
                </div>
            </article>
        @endforeach
    </div>
</div>
</section>
