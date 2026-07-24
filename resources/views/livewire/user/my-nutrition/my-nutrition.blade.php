<div>
       <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <x-stat-card label="Calories" value="1,640" unit="/ 2,200 kcal" hint="560 kcal remaining" accent="emerald" />
            <x-stat-card label="Protein" value="118" unit="/ 165 g" hint="72% of goal" accent="sky" />
            <x-stat-card label="Carbs" value="152" unit="/ 220 g" hint="69% of goal" accent="amber" />
            <x-stat-card label="Fat" value="48" unit="/ 70 g" hint="69% of goal" accent="rose" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Today's meal log --}}
            <div class="lg:col-span-2 rounded-2xl border border-zinc-800/70 bg-zinc-900/50">
                <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-800/70">
                    <div>
                        <h2 class="font-semibold text-white">Today's log</h2>
                        <p class="text-sm text-zinc-500">Friday, 24 July</p>
                    </div>
                    <button type="button" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-500 px-3 py-1.5 text-sm font-medium text-zinc-950 hover:bg-emerald-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Log meal
                    </button>
                </div>

                <ul class="divide-y divide-zinc-800/70">
                    @foreach([
                        ['meal' => 'Breakfast', 'name' => 'Greek yogurt, oats & berries', 'time' => '7:20 AM', 'kcal' => 420],
                        ['meal' => 'Lunch', 'name' => 'Grilled chicken bowl', 'time' => '12:45 PM', 'kcal' => 610],
                        ['meal' => 'Snack', 'name' => 'Protein shake & almonds', 'time' => '3:30 PM', 'kcal' => 310],
                        ['meal' => 'Dinner', 'name' => 'Salmon, rice & greens', 'time' => '7:00 PM', 'kcal' => 300],
                    ] as $entry)
                        <li class="flex items-center justify-between px-6 py-4">
                            <div>
                                <p class="text-sm font-medium text-zinc-200">{{ $entry['name'] }}</p>
                                <p class="text-xs text-zinc-500">{{ $entry['meal'] }} · {{ $entry['time'] }}</p>
                            </div>
                            <span class="text-sm font-medium text-zinc-300">{{ $entry['kcal'] }} kcal</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Side column --}}
            <div class="space-y-6">
                {{-- Water intake --}}
                <div class="rounded-2xl border border-zinc-800/70 bg-zinc-900/50 p-6">
                    <h2 class="font-semibold text-white mb-4">Water intake</h2>
                    <div class="flex items-end gap-1.5 mb-3">
                        @for($i = 1; $i <= 8; $i++)
                            <div class="flex-1 h-10 rounded-md {{ $i <= 5 ? 'bg-sky-500' : 'bg-zinc-800' }}"></div>
                        @endfor
                    </div>
                    <p class="text-sm text-zinc-400">5 / 8 glasses <span class="text-zinc-600">· 1.25L logged</span></p>
                </div>

                {{-- Macro plan --}}
                <div class="rounded-2xl border border-zinc-800/70 bg-zinc-900/50 p-6">
                    <h2 class="font-semibold text-white mb-4">Current plan</h2>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Goal</dt>
                            <dd class="text-zinc-200">Lean muscle gain</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Daily target</dt>
                            <dd class="text-zinc-200">2,200 kcal</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-zinc-500">Split</dt>
                            <dd class="text-zinc-200">30 / 40 / 30</dd>
                        </div>
                    </dl>
                    <a href="#" class="mt-4 inline-block text-sm font-medium text-emerald-400 hover:text-emerald-300">Adjust plan &rarr;</a>
                </div>
            </div>
        </div>



</div>
 
