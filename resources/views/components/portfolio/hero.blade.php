<section id="home" class="pt-26 pb-32 px-6 sm:px-8 bg-white">
    <div class="max-w-3xl mx-auto flex flex-col lg:flex-row lg:gap-12">
        <div class="flex-col justify-between">
            <h1 class="font-serif text-6xl md:text-7xl font-bold text-stone-900 mb-6 leading-tight">Kostas Kazazis</h1>
            <p class="font-serif text-2xl md:text-3xl text-stone-700 mb-4 font-light">Full-Stack Web Developer</p>
            <p class="text-lg text-stone-600 leading-relaxed mb-8 font-light">
                Every freelancer needs a website. Crafting clean, reliable and custom sites that get your name out
                there. My support, in your journey. Based in Düsseldorf.
            </p>
            <div class="mb-8 flex">
                <span
                    class="reveal inline-flex items-center gap-[9px] pl-3 pr-3.5 py-[7px] border border-line rounded-full font-mono text-[12px] text-ink-soft bg-card"
                >
                    <!-- Container for the dot -->
                    <span class="relative flex h-2 w-2 flex-shrink-0">
                        <!-- The Ping Ring (Absolute) -->
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[oklch(0.62_0.16_150)] opacity-75"
                        ></span>
                        <!-- The Static Dot (Relative) -->
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-[oklch(0.62_0.16_150)]"></span>
                    </span>

                    <!-- Text -->
                    <p class="m-0 p-0 leading-none">Available for new freelance work — Summer 2026</p>
                </span>
            </div>
        </div>

        <div class="pb-12 flex-shrink-0">
            <img
                src="https://s3.eu-north-1.amazonaws.com/kazazis.dev/profile-pic.png"
                alt="Kostas Kazazis"
                class="w-56 h-56 sm:w-72 sm:h-72 lg:w-82 lg:h-82 rounded-none mx-auto mb-10 object-cover border border-stone-300"
            />

            <div class="flex justify-center gap-8 mb-12">
                <a
                    href="https://github.com/konkazazis"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="GitHub"
                    class="text-stone-600 hover:text-stone-900 transition text-xl"
                >
                    <i class="fa-brands fa-github"></i>
                </a>
                <a
                    href="https://www.linkedin.com/in/konstantinos-kazazis-32a470228/"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="LinkedIn"
                    class="text-stone-600 hover:text-stone-900 transition text-xl"
                >
                    <i class="fa-brands fa-linkedin"></i>
                </a>
                <a
                    href="{{ route("blog") }}"
                    aria-label="Blog"
                    class="text-stone-600 hover:text-stone-900 transition text-xl"
                >
                    <i class="fa fa-pencil"></i>
                </a>
            </div>

            <div class="text-center">
                <a
                    href="#work"
                    class="inline-block text-sm font-medium text-stone-900 border border-stone-400 px-6 py-2 hover:bg-stone-50 transition smoothScroll tracking-wide"
                >
                    EXPLORE WORK
                </a>
            </div>
        </div>
    </div>
</section>
