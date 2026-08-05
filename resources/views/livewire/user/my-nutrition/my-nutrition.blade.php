<div>
    @if($activePlan)
        <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4">
            <x-stat-card label="Calories" :value="$activePlan->daily_calories ?? '—'" unit="kcal / day" accent="emerald" />
            <x-stat-card label="Protein" :value="$activePlan->protein_grams ?? '—'" unit="g / day" accent="sky" />
            <x-stat-card label="Carbs" :value="$activePlan->carbs_grams ?? '—'" unit="g / day" accent="amber" />
            <x-stat-card label="Fat" :value="$activePlan->fat_grams ?? '—'" unit="g / day" accent="rose" />
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Meals --}}
            <div class="rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900/50 lg:col-span-2">
                <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800/70">
                    <h2 class="font-semibold text-zinc-800 dark:text-white">{{ $activePlan->title }}</h2>
                    @if($activePlan->goal)
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $activePlan->goal }}</p>
                    @endif
                </div>

                @if($activePlan->meals->isNotEmpty())
                    <ul class="divide-y divide-zinc-200 dark:divide-zinc-800/70">
                        @foreach($activePlan->meals as $meal)
                            <li class="flex items-center justify-between px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ $meal->name }}</p>
                                    @if($meal->description)
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $meal->description }}</p>
                                    @endif
                                </div>
                                @if($meal->calories !== null)
                                    <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300">{{ $meal->calories }} kcal</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="px-6 py-8 text-center text-sm text-zinc-400 dark:text-zinc-500">No meals have been added to this plan yet.</p>
                @endif
            </div>

            {{-- Notes --}}
            <div class="space-y-6">
                <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800/70 dark:bg-zinc-900/50">
                    <h2 class="mb-4 font-semibold text-zinc-800 dark:text-white">Plan notes</h2>
                    @if($activePlan->notes)
                        <p class="text-sm whitespace-pre-line text-zinc-600 dark:text-zinc-300">{{ $activePlan->notes }}</p>
                    @else
                        <p class="text-sm text-zinc-400 dark:text-zinc-500">No additional notes from your coach.</p>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="flex items-center justify-center rounded-2xl border border-zinc-200 bg-white py-16 dark:border-zinc-800/70 dark:bg-zinc-900/50">
            <p class="text-sm text-zinc-400 dark:text-zinc-500">Your coach hasn't assigned you a nutrition plan yet.</p>
        </div>
    @endif

    @if($pastPlans->isNotEmpty())
        <div class="mt-8 rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900/50">
            <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800/70">
                <h2 class="font-semibold text-zinc-800 dark:text-white">Past plans</h2>
            </div>
            <ul class="divide-y divide-zinc-200 dark:divide-zinc-800/70">
                @foreach($pastPlans as $plan)
                    <li class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ $plan->title }}</p>
                            @if($plan->goal)
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $plan->goal }}</p>
                            @endif
                        </div>
                        <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ $plan->created_at->format('M j, Y') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
