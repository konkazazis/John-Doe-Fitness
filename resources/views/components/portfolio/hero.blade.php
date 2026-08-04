<section class="relative overflow-hidden bg-stone-50" id="home">
    <div
        class="mx-auto grid max-w-7xl items-center gap-12 px-6 py-20 lg:grid-cols-2 lg:px-0 lg:py-16"
    >
        {{-- Copy --}}
        <div>
            <span class="section-label">Coaching &amp; Nutrition</span>
            <h1
                class="font-display text-5xl leading-[1.05] font-bold tracking-tight text-stone-900 sm:text-6xl"
            >
                Train harder.
                <span class="text-[#eb5424]">Fuel smarter.</span>
            </h1>
            <p class="mt-6 max-w-lg text-lg text-stone-600">
                One-to-one strength coaching and personalised nutrition plans,
                built around your body, your schedule and your goals — not a
                generic template.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a
                    href="#contact"
                    class="smoothScroll inline-flex items-center justify-center rounded-full bg-[#eb5424] px-7 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#c94219]"
                >
                    Book a free consult
                </a>
                <a
                    href="#services"
                    class="smoothScroll inline-flex items-center justify-center rounded-full border border-stone-300 px-7 py-3 text-sm font-semibold text-stone-800 transition-colors hover:border-stone-400"
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

        {{-- Diagonal visual panel --}}
        <div class="relative h-[420px] lg:h-[520px]">
            <div
                class="absolute inset-0 rounded-[2.5rem] bg-[#eb5424]"
                style="clip-path: polygon(12% 0, 100% 0, 100% 100%, 0 100%)"
            ></div>

            <img
                src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=900&q=80"
                alt="Coach guiding a client through a strength session"
                fetchpriority="high"
                class="absolute inset-0 h-full w-full rounded-[2.5rem] object-cover"
                style="
                    clip-path: polygon(12% 0, 100% 0, 100% 100%, 0 100%);
                    mix-blend-mode: luminosity;
                    opacity: 0.85;
                "
            />

            <div
                class="absolute bottom-6 left-6 max-w-[220px] rounded-2xl bg-white/95 px-5 py-4 shadow-lg backdrop-blur"
            >
                <p class="text-xs tracking-[0.2em] text-stone-500 uppercase">
                    This week
                </p>
                <p class="font-display mt-1 text-2xl font-bold text-stone-900">
                    6 spots left
                </p>
                <p class="mt-1 text-xs text-stone-500">
                    for new 1:1 coaching intakes
                </p>
            </div>
        </div>
    </div>
</section>
