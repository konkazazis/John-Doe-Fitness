@php
    $testimonials = [
        [
            "name" => "Priya M.",
            "result" => "Down 12kg, first pull-up at 34",
            "quote" => "The nutrition side actually stuck this time because it was built around meals I already cook, not a meal plan pulled off a website.",
        ],
        [
            "name" => "Dan O.",
            "result" => "+40kg on his deadlift in 9 months",
            "quote" => "I have tried three coaches before. This is the first program that changed based on how my actual sessions went, week to week.",
        ],
        [
            "name" => "Sofia R.",
            "result" => "Marathon PB, race-week fuelling dialed in",
            "quote" => "Getting training and nutrition from the same person meant nothing ever contradicted itself. Everything pointed the same direction.",
        ],
    ];
@endphp

<section class="py-24 bg-stone-900 text-stone-50">
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
        class="mx-auto max-w-4xl px-6 lg:px-8 text-center"
    >
        <span class="section-label text-stone-400">Results, not promises</span>

        <div
            class="relative min-h-[180px] flex items-center justify-center mt-10"
        >
            @foreach ($testimonials as $i => $t)
                <div
                    x-show="active === {{ $i }}"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute inset-0"
                >
                    <p class="font-display text-2xl sm:text-3xl leading-snug">
                        &ldquo;{{ $t["quote"] }}&rdquo;
                    </p>
                    <p class="mt-6 text-[#eb5424] font-semibold">
                        {{ $t["name"] }}
                    </p>
                    <p class="text-stone-400 text-sm">{{ $t["result"] }}</p>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-center gap-6 mt-10">
            <button
                @click="prev()"
                aria-label="Previous testimonial"
                class="w-10 h-10 rounded-full border border-stone-700 flex items-center justify-center hover:border-stone-500 transition-colors"
            >
                <svg
                    class="w-4 h-4"
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
                        class="w-2 h-2 rounded-full transition-colors"
                        :class="active === {{ $i }} ? 'bg-[#eb5424]' : 'bg-stone-700'"
                        aria-label="Go to testimonial {{ $i + 1 }}"
                    ></button>
                @endforeach
            </div>

            <button
                @click="next()"
                aria-label="Next testimonial"
                class="w-10 h-10 rounded-full border border-stone-700 flex items-center justify-center hover:border-stone-500 transition-colors"
            >
                <svg
                    class="w-4 h-4"
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
