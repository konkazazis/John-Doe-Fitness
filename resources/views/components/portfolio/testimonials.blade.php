@props([
    "testimonials",
])

<section id="testimonials" class="bg-ink py-24 text-white">
    <div
        x-data="{
            active: 0,
            count: {{ count($testimonials) }},
            next() {
                this.active = (this.active + 1) % this.count
            },
            prev() {
                this.active = (this.active - 1 + this.count) % this.count
            },
        }"
        class="mx-auto max-w-4xl px-6 text-center lg:px-8"
    >
        <span class="section-label justify-center">Results, not promises</span>

        <div
            class="relative mt-10 flex min-h-[180px] items-center justify-center"
        >
            @foreach ($testimonials as $i => $t)
                <div
                    x-show="active === {{ $i }}"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute inset-0"
                >
                    <p class="text-2xl leading-snug font-semibold sm:text-3xl">
                        &ldquo;{{ $t["quote"] }}&rdquo;
                    </p>
                    <p class="mt-6 font-semibold text-brand">
                        {{ $t["client"] }}
                    </p>
                    <p class="text-sm text-white/50">{{ $t["description"] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-10 flex items-center justify-center gap-6">
            <button
                @click="prev()"
                aria-label="Previous testimonial"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 transition-colors hover:border-white/50"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
            </button>

            <div class="flex gap-2">
                @foreach ($testimonials as $i => $t)
                    <button
                        @click="active = {{ $i }}"
                        class="h-2 w-2 rounded-full transition-colors"
                        :class="active === {{ $i }} ? 'bg-brand' : 'bg-white/20'"
                        aria-label="Go to testimonial {{ $i + 1 }}"
                    ></button>
                @endforeach
            </div>

            <button
                @click="next()"
                aria-label="Next testimonial"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 transition-colors hover:border-white/50"
            >
                <svg
                    class="h-4 w-4"
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
            </button>
        </div>
    </div>
</section>
