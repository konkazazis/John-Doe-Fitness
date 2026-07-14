<section id="pricing" class="py-24 bg-stone-50">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex flex-col items-center text-center mb-14">
            <span class="section-label">Coaching plans</span>
            <h2 class="section-heading">Pick your plan</h2>
            <p class="text-stone-600 text-lg max-w-xl">
                Every plan includes both training and nutrition coaching.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 items-stretch">
            @foreach ($plans as $plan)
                @php
                    $isFuel = $plan["group"] === "fuel";
                @endphp

                <div
                    class="panel-card flex flex-col {{ $plan["featured"] ?? false ? "ring-2 ring-[#eb5424] relative" : "" }}"
                >
                    @if ($plan["featured"] ?? false)
                        <span class="absolute -top-3 left-8 category-badge">
                            Most popular
                        </span>
                    @endif

                    <span
                        class="{{ $isFuel ? "tag-badge-sprout" : "tag-badge" }}"
                    >
                        {{ $plan->tag }}
                    </span>

                    <h3
                        class="font-display text-2xl font-bold text-stone-900 mt-4"
                    >
                        {{ $plan["name"] }}
                    </h3>
                    <p class="text-stone-600 mt-2 mb-6">
                        {{ $plan->description }}
                    </p>

                    <div class="mb-6">
                        <span
                            class="font-display text-4xl font-bold text-stone-900 tabular-nums"
                        >
                            ${{ $plan->price}}
                        </span>
                        <span class="text-stone-500">/month</span>
                    </div>

                    <ul class="space-y-3 mb-8 flex-1">
                        @foreach ($plan["features"] as $feature)
                            <li
                                class="flex items-start gap-2 text-sm text-stone-700"
                            >
                                <svg
                                    class="w-4 h-4 mt-0.5 flex-shrink-0 {{ $isFuel ? "text-[#4c7a3f]" : "text-[#eb5424]" }}"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    <a
                        href="#contact"
                        class="smoothScroll text-center rounded-full px-6 py-3 text-sm font-semibold transition-colors {{ $plan["featured"] ?? false ? "bg-[#eb5424] text-white hover:bg-[#c94219]" : "border border-stone-300 text-stone-800 hover:border-stone-400" }}"
                    >
                        Start with {{ $plan->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
