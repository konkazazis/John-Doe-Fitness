<section class="relative overflow-hidden bg-cream" id="home">
    <div
        class="absolute -top-10 -left-16 -z-0 h-64 w-64 rounded-full bg-peach opacity-90"
    ></div>
    <div
        class="absolute top-40 right-0 -z-0 h-40 w-40 rotate-45 bg-ink/[0.03]"
    ></div>
    <div
        class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 py-20 lg:grid-cols-2 lg:px-0 lg:py-16"
    >
        {{-- Copy --}}
        <div class="relative z-10">
            <div
                class="mb-6 inline-flex items-center gap-2 rounded-full bg-ink px-4 py-2 text-sm font-bold text-white"
            >
                <span class="h-2 w-2 rounded-full bg-brand"></span>
                Coaching &amp; Nutrition
            </div>
            <h1
                class="font-display text-5xl leading-[1.05] tracking-tight text-ink uppercase sm:text-6xl"
            >
                Train harder.
                <span class="text-brand">Fuel smarter.</span>
            </h1>
            <p class="mt-6 max-w-lg text-lg text-ink/60">
                One-to-one strength coaching and personalised nutrition plans,
                built around your body, your schedule and your goals — not a
                generic template.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a
                    href="#contact"
                    class="smoothScroll inline-flex items-center justify-center rounded-full bg-brand px-7 py-4 text-sm font-bold text-white transition-colors hover:bg-brand-dark"
                >
                    Book a free consult
                </a>
                <a
                    href="#services"
                    class="smoothScroll inline-flex items-center justify-center rounded-full border-2 border-ink px-7 py-4 text-sm font-bold text-ink transition-colors hover:bg-ink hover:text-white"
                >
                    See what's included
                </a>
            </div>

            {{-- Live stat HUD --}}
            <div
                x-data="{
                    clients: 0,
                    sessions: 0,
                    mealsPlanned: 0,
                    targets: { clients: 120, sessions: 4800, mealsPlanned: 32000 },
                    animate() {
                        const duration = 1400
                        const start = performance.now()
                        const step = (now) => {
                            const p = Math.min((now - start) / duration, 1)
                            const eased = 1 - Math.pow(1 - p, 3)
                            this.clients = Math.round(this.targets.clients * eased)
                            this.sessions = Math.round(this.targets.sessions * eased)
                            this.mealsPlanned = Math.round(this.targets.mealsPlanned * eased)
                            if (p < 1) requestAnimationFrame(step)
                        }
                        requestAnimationFrame(step)
                    },
                }"
                x-init="animate()"
                class="mt-12 grid max-w-md grid-cols-3 gap-6"
            >
                <div class="stat-chip">
                    <span class="stat-value" x-text="clients"></span>
                    <span class="stat-label">Active clients</span>
                </div>
                <div class="stat-chip">
                    <span
                        class="stat-value"
                        x-text="sessions.toLocaleString()"
                    ></span>
                    <span class="stat-label">Sessions coached</span>
                </div>
                <div class="stat-chip">
                    <span
                        class="stat-value"
                        x-text="mealsPlanned.toLocaleString()"
                    ></span>
                    <span class="stat-label">Meals planned</span>
                </div>
            </div>
        </div>

        {{-- Visual panel --}}
        <div class="relative z-10 h-[420px] lg:h-[520px]">
            <img
                src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=900&q=80"
                alt="Coach guiding a client through a strength session"
                fetchpriority="high"
                class="h-full w-full rounded-[2.5rem] border-4 border-ink object-cover"
            />

            <div
                class="absolute -bottom-6 -left-6 flex h-28 w-28 items-center justify-center rounded-full bg-brand text-center text-sm leading-tight font-black text-white"
            >
                JOIN<br />TODAY
            </div>

            <div
                class="absolute top-6 right-6 max-w-[200px] rounded-2xl border-2 border-ink bg-white px-5 py-4"
            >
                <p class="text-xs tracking-[0.2em] text-ink/50 uppercase">
                    This week
                </p>
                <p class="font-display mt-1 text-xl text-ink">
                    6 spots left
                </p>
                <p class="mt-1 text-xs text-ink/50">
                    for new 1:1 coaching intakes
                </p>
            </div>
        </div>
    </div>
</section>
