@props([
    "projects",
])

<section id="portfolio" class="py-24 px-6 sm:px-8 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="max-w-2xl mx-auto text-center mb-20">
            <span class="section-label justify-center">Selected work</span>
            <h2 class="section-heading">Portfolio</h2>
        </div>

        <div class="flex flex-col gap-[clamp(40px,6vw,76px)]">
            @foreach ($projects as $i => $project)
                <article
                    class="reveal grid items-center gap-[clamp(28px,4vw,56px)] grid-cols-1 md:grid-cols-[1.05fr_0.95fr]"
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
                                class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.035]"
                            />
                        @endif

                        <span
                            class="absolute top-3.5 right-3.5 bg-white/90 border border-stone-200 rounded-full px-3 py-[7px] text-xs font-medium tracking-wide inline-flex items-center gap-[7px] backdrop-blur opacity-0 -translate-y-1.5 transition group-hover:opacity-100 group-hover:translate-y-0"
                        >
                            Visit live
                            <span>&#8599;</span>
                        </span>
                    </a>
                    <div>
                        <h3
                            class="font-display mt-3 text-[clamp(1.5rem,3vw,2.1rem)] tracking-tight font-bold leading-[1.08] text-stone-900"
                        >
                            <a
                                href="{{ $project->live_url ?? "#" }}"
                                @if($project->live_url) target="_blank" rel="noopener" @endif
                                class="hover:text-[#eb5424] transition-colors"
                            >
                                {{ $project->title }}
                            </a>
                        </h3>
                        <p class="mt-3.5 text-stone-600 max-w-[44ch]">
                            {{ $project->description }}
                        </p>
                        @if ($project->technologies)
                            <div class="flex flex-wrap gap-2 mt-5">
                                @foreach (array_map("trim", explode(",", $project->technologies)) as $tech)
                                    <span class="tag-badge">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if ($project->live_url)
                            <a
                                href="{{ $project->live_url }}"
                                target="_blank"
                                rel="noopener"
                                class="group/l inline-flex items-center gap-2.5 mt-6 font-semibold text-[0.95rem] text-stone-900 border-b-[1.5px] border-stone-300 pb-0.5 transition-all hover:border-[#eb5424] hover:text-[#eb5424] hover:gap-3.5"
                            >
                                View project
                                <span
                                    class="transition-transform group-hover/l:translate-x-0.5"
                                >
                                    &rarr;
                                </span>
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
