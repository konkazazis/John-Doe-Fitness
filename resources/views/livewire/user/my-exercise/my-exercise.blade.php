<div>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card label="This week" value="4" unit="/ 5 workouts" hint="1 session to go" accent="emerald" />
        <x-stat-card label="Streak" value="12" unit="days" hint="Personal best: 18" accent="amber" />
        <x-stat-card label="Active minutes" value="238" unit="min" hint="+42 vs last week" accent="sky" />
        <x-stat-card label="Calories burned" value="1,860" unit="kcal" hint="This week" accent="rose" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Today's workout --}}
        <div class="lg:col-span-2 rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900/50">
            <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-200 dark:border-zinc-800/70">
                <div>
                    <h2 class="font-semibold text-zinc-800 dark:text-white">Today's workout</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Upper body strength · 45 min</p>
                </div>
                <button type="button" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-500 px-3 py-1.5 text-sm font-medium text-zinc-950 hover:bg-emerald-400 transition-colors">
                    Start session
                </button>
            </div>

            <ul class="divide-y divide-zinc-200 dark:divide-zinc-800/70">
                @foreach([
                    ['name' => 'Bench press', 'sets' => '4 sets × 8 reps', 'load' => '70 kg'],
                    ['name' => 'Barbell row', 'sets' => '4 sets × 10 reps', 'load' => '60 kg'],
                    ['name' => 'Overhead press', 'sets' => '3 sets × 10 reps', 'load' => '40 kg'],
                    ['name' => 'Lat pulldown', 'sets' => '3 sets × 12 reps', 'load' => '55 kg'],
                    ['name' => 'Cable tricep press', 'sets' => '3 sets × 15 reps', 'load' => '25 kg'],
                ] as $exercise)
                    <li class="flex items-center justify-between px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12h12M6 8h12M6 16h12" /></svg>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ $exercise['name'] }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $exercise['sets'] }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300">{{ $exercise['load'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Side column --}}
        <div class="space-y-6">
            {{-- Weekly schedule --}}
            <div class="rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900/50 p-6">
                <h2 class="font-semibold text-zinc-800 dark:text-white mb-4">This week</h2>
                <div class="space-y-2.5">
                    @foreach([
                        ['day' => 'Mon', 'label' => 'Upper body', 'done' => true],
                        ['day' => 'Tue', 'label' => 'Rest', 'done' => true],
                        ['day' => 'Wed', 'label' => 'Lower body', 'done' => true],
                        ['day' => 'Thu', 'label' => 'Cardio', 'done' => true],
                        ['day' => 'Fri', 'label' => 'Upper body', 'done' => false],
                        ['day' => 'Sat', 'label' => 'Full body', 'done' => false],
                        ['day' => 'Sun', 'label' => 'Rest', 'done' => false],
                    ] as $day)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-500 dark:text-zinc-400 w-10">{{ $day['day'] }}</span>
                            <span class="flex-1 text-zinc-700 dark:text-zinc-300">{{ $day['label'] }}</span>
                            @if($day['done'])
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            @else
                                <span class="w-4 h-4 rounded-full border border-zinc-300 dark:border-zinc-700"></span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Personal bests --}}
            <div class="rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900/50 p-6">
                <h2 class="font-semibold text-zinc-800 dark:text-white mb-4">Personal bests</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-zinc-500 dark:text-zinc-400">Bench press</dt>
                        <dd class="text-zinc-700 dark:text-zinc-200">80 kg</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-zinc-500 dark:text-zinc-400">Squat</dt>
                        <dd class="text-zinc-700 dark:text-zinc-200">110 kg</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-zinc-500 dark:text-zinc-400">Deadlift</dt>
                        <dd class="text-zinc-700 dark:text-zinc-200">140 kg</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-zinc-500 dark:text-zinc-400">5k run</dt>
                        <dd class="text-zinc-700 dark:text-zinc-200">24:12</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
