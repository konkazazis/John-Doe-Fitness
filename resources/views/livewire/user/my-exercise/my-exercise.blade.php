<div>
    @if($activePlan)
        <div class="rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900/50">
            <div class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800/70">
                <h2 class="font-semibold text-zinc-800 dark:text-white">{{ $activePlan->title }}</h2>
                @if($activePlan->goal)
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $activePlan->goal }}</p>
                @endif
            </div>

            @if($activePlan->exercises->isNotEmpty())
                <ul class="divide-y divide-zinc-200 dark:divide-zinc-800/70">
                    @foreach($activePlan->exercises as $exercise)
                        <li class="flex items-center justify-between px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12h12M6 8h12M6 16h12" /></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ $exercise->name }}</p>
                                    @if($exercise->description)
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $exercise->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                                @if($exercise->sets !== null || $exercise->reps !== null)
                                    {{ $exercise->sets ?? '—' }} sets × {{ $exercise->reps ?? '—' }} reps
                                @endif
                                @if($exercise->weight)
                                    <span class="text-zinc-400 dark:text-zinc-500">· {{ $exercise->weight }}</span>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="px-6 py-8 text-center text-sm text-zinc-400 dark:text-zinc-500">No exercises have been added to this plan yet.</p>
            @endif

            @if($activePlan->notes)
                <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800/70">
                    <p class="text-sm whitespace-pre-line text-zinc-600 dark:text-zinc-300">{{ $activePlan->notes }}</p>
                </div>
            @endif
        </div>
    @else
        <div class="flex items-center justify-center rounded-2xl border border-zinc-200 bg-white py-16 dark:border-zinc-800/70 dark:bg-zinc-900/50">
            <p class="text-sm text-zinc-400 dark:text-zinc-500">Your coach hasn't assigned you an exercise plan yet.</p>
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
