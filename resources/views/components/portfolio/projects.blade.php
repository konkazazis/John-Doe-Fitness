@props(['projects'])

<section id="portfolio" class="py-24 px-6 sm:px-8 bg-white border-t border-stone-300">
    <div class="max-w-6xl mx-auto">
        <h2 class="font-serif text-5xl md:text-6xl font-bold text-stone-900 mb-20 text-center">
            Portfolio
        </h2>

        <div class="lex flex-col gap-[clamp(40px,6vw,76px)]">
            @foreach($projects as $i => $project)
                <article class="mb-8 reveal grid items-center gap-[clamp(28px,4vw,56px)] grid-cols-1 md:grid-cols-[1.05fr_0.95fr]">
                    <a href="{{ $project->live_url ?? '#' }}" @if($project->live_url) target="_blank" rel="noopener" @endif
                       class="group relative rounded-[14px] overflow-hidden border border-line bg-paper-2 aspect-[16/11] shadow-[0_30px_70px_-44px_oklch(0.3_0.04_60_/_0.55)] {{ $i % 2 ? 'md:order-2' : '' }}">
                        @if($project->coverUrl())
                            <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.035]">
                        @endif
                        <span class="absolute top-3.5 right-3.5 bg-card/90 border border-line rounded-full px-3 py-[7px] font-mono text-[11.5px] tracking-[0.04em] inline-flex items-center gap-[7px] backdrop-blur opacity-0 -translate-y-1.5 transition group-hover:opacity-100 group-hover:translate-y-0">Visit live <span>&#8599;</span></span>
                    </a>
                    <div>
                        <h3 class="mt-3 text-[clamp(1.5rem,3vw,2.1rem)] tracking-[-0.025em] font-bold leading-[1.08]">
                            <a href="{{ $project->live_url ?? '#' }}" @if($project->live_url) target="_blank" rel="noopener" @endif class="hover:text-accent-ink transition">{{ $project->title }}</a>
                        </h3>
                        <p class="mt-3.5 text-muted max-w-[44ch]">{{ $project->description }}</p>
                        @if($project->technologies)
                            <div class="flex flex-wrap gap-1.75 mt-5">
                                @foreach(array_map('trim', explode(',', $project->technologies)) as $tech)
                                    <span class="p-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        @if($project->live_url)
                            <a href="{{ $project->live_url }}" target="_blank" rel="noopener"
                               class="group/l inline-flex items-center gap-2.5 mt-6 font-semibold text-[0.95rem] border-b-[1.5px] border-line pb-0.75 transition-all hover:border-accent hover:gap-3.25">
                                View project <span class="arr text-accent-ink">&rarr;</span>
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
