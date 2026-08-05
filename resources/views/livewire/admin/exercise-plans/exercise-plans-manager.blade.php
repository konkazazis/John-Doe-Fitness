<div class="p-6 lg:p-10">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">Exercise Plans</h1>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Build and assign exercise plans to your clients.</p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

        {{-- Client list --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                @if($clients->isEmpty())
                    <div class="py-16 text-center text-sm text-zinc-400 dark:text-zinc-500">No clients yet.</div>
                @else
                    <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @foreach($clients as $client)
                            <button wire:click="selectClient({{ $client->id }})"
                                class="w-full px-5 py-4 text-left transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50 {{ $viewingUserId === $client->id ? 'bg-zinc-50 dark:bg-zinc-800/50' : '' }}">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $client->username }}</p>
                                        <p class="mt-0.5 truncate text-xs text-zinc-400 dark:text-zinc-500">{{ $client->email }}</p>
                                    </div>
                                    <span class="shrink-0 rounded-full bg-zinc-100 px-2 py-0.5 text-xs font-medium text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                        {{ $client->exercise_plans_count }} {{ Str::plural('plan', $client->exercise_plans_count) }}
                                    </span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Plans for selected client --}}
        <div class="lg:col-span-3">
            @if($currentClient)
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">{{ $currentClient->username }}'s Plans</h2>
                    <button wire:click="openCreate"
                        class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                        New plan
                    </button>
                </div>

                @if($plans->isEmpty())
                    <div class="flex items-center justify-center rounded-2xl border border-zinc-100 bg-white py-16 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <p class="text-sm text-zinc-400 dark:text-zinc-500">No plans yet for this client.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($plans as $plan)
                            <div class="rounded-2xl border border-zinc-100 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h3 class="truncate text-sm font-bold text-zinc-800 dark:text-zinc-100">{{ $plan->title }}</h3>
                                            @if($plan->is_active)
                                                <span class="shrink-0 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400">Active</span>
                                            @endif
                                        </div>
                                        @if($plan->goal)
                                            <p class="mt-0.5 text-xs text-zinc-400 dark:text-zinc-500">{{ $plan->goal }}</p>
                                        @endif
                                    </div>
                                    <div class="flex shrink-0 items-center gap-1">
                                        @unless($plan->is_active)
                                            <button wire:click="activate({{ $plan->id }})"
                                                class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-zinc-500 transition-colors hover:bg-zinc-50 hover:text-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-800/50 dark:hover:text-zinc-100">
                                                Activate
                                            </button>
                                        @endunless
                                        <button wire:click="openEdit({{ $plan->id }})"
                                            class="rounded-lg p-1.5 text-zinc-400 transition-colors hover:bg-zinc-50 hover:text-zinc-700 dark:text-zinc-500 dark:hover:bg-zinc-800/50 dark:hover:text-zinc-200">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button wire:click="delete({{ $plan->id }})"
                                            wire:confirm="Delete this exercise plan?"
                                            class="rounded-lg p-1.5 text-zinc-400 transition-colors hover:bg-red-50 hover:text-red-500 dark:text-zinc-500 dark:hover:bg-red-950/30">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>

                                @if($plan->exercises->isNotEmpty())
                                    <div class="mt-4 divide-y divide-zinc-50 border-t border-zinc-100 dark:divide-zinc-800 dark:border-zinc-800">
                                        @foreach($plan->exercises as $exercise)
                                            <div class="flex items-center justify-between py-2.5">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ $exercise->name }}</p>
                                                    @if($exercise->description)
                                                        <p class="truncate text-xs text-zinc-400 dark:text-zinc-500">{{ $exercise->description }}</p>
                                                    @endif
                                                </div>
                                                <span class="shrink-0 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                                    @if($exercise->sets !== null || $exercise->reps !== null)
                                                        {{ $exercise->sets ?? '—' }} × {{ $exercise->reps ?? '—' }}
                                                    @endif
                                                    @if($exercise->weight)
                                                        · {{ $exercise->weight }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if($plan->notes)
                                    <p class="mt-4 border-t border-zinc-100 pt-3 text-xs text-zinc-500 italic dark:border-zinc-800 dark:text-zinc-400">{{ $plan->notes }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="flex items-center justify-center rounded-2xl border border-zinc-100 bg-white py-16 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm text-zinc-400 dark:text-zinc-500">Select a client to view their plans</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Create/Edit modal --}}
    <div x-data="{ show: @entangle('showModal').live }"
        x-show="show"
        x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @keydown.escape.window="$wire.showModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
        style="display: none;">
        <div @click.stop
            class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl border border-zinc-100 bg-white p-6 shadow-xl dark:border-zinc-800 dark:bg-zinc-900"
            x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">{{ $editingId ? 'Edit Plan' : 'New Plan' }}</h2>
                <button wire:click="$set('showModal', false)" class="p-1 text-zinc-400 hover:text-zinc-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Title</label>
                        <input type="text" wire:model="title" placeholder="Upper Body Strength - March"
                            class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                        @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Goal</label>
                        <input type="text" wire:model="goal" placeholder="Build upper body strength"
                            class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                        @error('goal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <label class="block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Exercises</label>
                        <button type="button" wire:click="addExercise" class="text-xs font-semibold text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">+ Add exercise</button>
                    </div>
                    <div class="space-y-3">
                        @foreach($exercises as $i => $exercise)
                            <div class="flex items-start gap-2 rounded-lg border border-zinc-100 p-3 dark:border-zinc-800">
                                <div class="grid flex-1 grid-cols-2 gap-2 sm:grid-cols-6">
                                    <input type="text" wire:model="exercises.{{ $i }}.name" placeholder="Bench press"
                                        class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none sm:col-span-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                                    <input type="text" wire:model="exercises.{{ $i }}.description" placeholder="Notes / tempo"
                                        class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none sm:col-span-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                                    <input type="number" wire:model="exercises.{{ $i }}.sets" placeholder="Sets"
                                        class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                                    <input type="number" wire:model="exercises.{{ $i }}.reps" placeholder="Reps"
                                        class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                                    <input type="text" wire:model="exercises.{{ $i }}.weight" placeholder="Weight (e.g. 70kg)"
                                        class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none sm:col-span-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                                </div>
                                <button type="button" wire:click="removeExercise({{ $i }})" class="mt-1.5 shrink-0 text-zinc-400 hover:text-red-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                @error("exercises.{$i}.name") <p class="col-span-full mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        @endforeach
                        @if(empty($exercises))
                            <p class="text-xs text-zinc-400 dark:text-zinc-500">No exercises added yet.</p>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Notes</label>
                    <textarea wire:model="notes" rows="3" placeholder="Any additional guidance for this plan…"
                        class="w-full resize-none rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100"></textarea>
                    @error('notes') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <label class="inline-flex cursor-pointer items-center gap-2">
                    <input type="checkbox" wire:model="is_active"
                        class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900 dark:border-zinc-600">
                    <span class="text-sm text-zinc-600 dark:text-zinc-300">Make this the active plan</span>
                </label>

                <div class="mt-6 flex justify-end gap-3 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 text-sm font-semibold text-zinc-500 hover:text-zinc-900">Cancel</button>
                    <button wire:click="save" wire:loading.attr="disabled"
                        class="rounded-lg bg-zinc-900 px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 disabled:opacity-50 dark:bg-zinc-100 dark:text-zinc-900">
                        <span wire:loading.remove wire:target="save">{{ $editingId ? 'Save changes' : 'Create plan' }}</span>
                        <span wire:loading wire:target="save">Saving…</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
