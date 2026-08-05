@php
    $services = [
        [
            'group' => 'train',
            'title' => '1:1 Strength Coaching',
            'desc' => 'Progressive programming built around your equipment, injury history and lifting goals, adjusted every week based on your logged sessions.',
            'tags' => ['Strength', 'Mobility', 'In-person or remote'],
        ],
        [
            'group' => 'train',
            'title' => 'Small Group Training',
            'desc' => 'Same individual attention to form and load, split across a group of 3-4, for people who train better with company.',
            'tags' => ['Groups of 3-4', 'Twice weekly'],
        ],
        [
            'group' => 'fuel',
            'title' => 'Personalised Meal Plans',
            'desc' => 'Macros and meal timing built around your training load, food preferences and schedule — not a copy-pasted 1,500 calorie template.',
            'tags' => ['Macro coaching', 'Grocery lists'],
        ],
        [
            'group' => 'fuel',
            'title' => 'Habit & Behaviour Coaching',
            'desc' => 'Weekly check-ins on sleep, stress and adherence, so the plan flexes around your life instead of the other way round.',
            'tags' => ['Weekly check-ins', 'Sustainable pace'],
        ],
    ];
@endphp

<section id="services" class="bg-cream-alt py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-14 max-w-2xl text-center md:mx-auto md:text-center">
            <span class="section-label justify-center">What I offer</span>
            <h2 class="section-heading">Two disciplines, one plan</h2>
            <p class="text-lg text-ink/60">
                Training and nutrition are coached together, not sold as
                separate add-ons — because progress on the bar depends on what's
                on your plate.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($services as $service)
                @php
                    $isFuel = $service['group'] === 'fuel';
                @endphp

                <div
                    class="relative overflow-hidden rounded-[2rem] p-8 {{ $isFuel ? "bg-brand" : "bg-ink" }}"
                >
                    <div
                        class="absolute -right-10 -bottom-10 h-40 w-40 rounded-full opacity-20 {{ $isFuel ? "bg-ink" : "bg-brand" }}"
                    ></div>

                    <div
                        class="relative mb-6 flex h-14 w-14 items-center justify-center rounded-2xl {{ $isFuel ? "bg-ink" : "bg-brand" }}"
                    >
                        <span class="text-2xl">{{ $isFuel ? "🥗" : "🏋️" }}</span>
                    </div>

                    <span
                        class="relative {{ $isFuel ? "category-badge bg-ink" : "category-badge" }}"
                    >
                        {{ $isFuel ? "Fuel" : "Train" }}
                    </span>
                    <h3
                        class="font-display relative mt-4 mb-2 text-2xl text-white uppercase"
                    >
                        {{ $service["title"] }}
                    </h3>
                    <p class="relative mb-5 text-sm text-white/80">{{ $service["desc"] }}</p>
                    <div class="relative flex flex-wrap gap-2">
                        @foreach ($service["tags"] as $tag)
                            <span
                                class="rounded-full border border-white/30 bg-white/10 px-2.5 py-0.5 text-xs font-medium text-white"
                            >
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
