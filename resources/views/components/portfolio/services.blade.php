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

<section id="services" class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-14 max-w-2xl">
            <span class="section-label">What I offer</span>
            <h2 class="section-heading">Two disciplines, one plan</h2>
            <p class="text-lg text-stone-600">
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
                    class="panel-card {{ $isFuel ? "border-[#4c7a3f]/20" : "border-[#eb5424]/20" }}"
                >
                    <span
                        class="{{ $isFuel ? "category-badge-sprout" : "category-badge" }}"
                    >
                        {{ $isFuel ? "Fuel" : "Train" }}
                    </span>
                    <h3
                        class="font-display mt-4 mb-2 text-2xl font-bold text-stone-900"
                    >
                        {{ $service["title"] }}
                    </h3>
                    <p class="mb-5 text-stone-600">{{ $service["desc"] }}</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($service["tags"] as $tag)
                            <span
                                class="{{ $isFuel ? "tag-badge-sprout" : "tag-badge" }}"
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
