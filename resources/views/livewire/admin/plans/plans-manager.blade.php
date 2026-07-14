<div class="p-6 lg:p-10">

    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">Plans</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Manage your plans.</p>
        </div>
        <button wire:click="openCreate"
                class="inline-flex items-center gap-2 bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-zinc-700 dark:hover:bg-zinc-300 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Plan
        </button>
    </div>

    <div class="mb-6">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search plans..."
               class="w-full max-w-xs border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 bg-white dark:bg-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900">
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm overflow-hidden">
        @if($plans->isEmpty())
            <div class="py-16 text-center text-zinc-400 dark:text-zinc-500 text-sm">No plans yet.</div>
        @else
            <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/40">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wide">Name</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wide">Price</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wide">Description</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wide">Tag</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wide">Features</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                    @foreach($plans as $plan)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 shrink-0 flex items-center justify-center">
                                        {{ $plan->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400 text-xs hidden md:table-cell">
                                {{ $plan->price }}
                            </td>
                             <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400 text-xs hidden md:table-cell">
                                {{ substr($plan->description, 0 , 20) . ' ' . "..." ?? '—' }}
                            </td>
                            <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400 text-xs hidden md:table-cell">
                                {{ substr($plan->tag, 0 , 20) . ' ' . "..." ?? '—' }}
                            </td>
                            <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400 text-xs hidden md:table-cell">
                                @php
                                    $featuresText = implode(', ', $plan->features ?? []);
                                @endphp
                                {{ $featuresText ? str($featuresText)->limit(20) : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="openEdit({{ $plan->id }})"
                                            class="text-xs font-semibold text-zinc-500 hover:text-zinc-900 transition-colors px-2 py-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800">Edit</button>
                                    <button wire:click="confirmDelete({{ $plan->id }})"
                                            class="text-xs font-semibold text-red-400 hover:text-red-600 transition-colors px-2 py-1 rounded hover:bg-red-50 dark:hover:bg-red-950/30">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @if($plans->hasPages())
                <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800">{{ $plan->links() }}</div>
            @endif
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    <div x-data="{ show: @entangle('showModal').live }"
         x-show="show"
         x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @keydown.escape.window="$wire.showModal = false"
         class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;">
        <div @click.stop
             class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xl w-full max-w-xl max-h-[90vh] overflow-y-auto p-6 border border-zinc-100 dark:border-zinc-800"
             x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">{{ $editingId ? 'Edit Plan' : 'New Plan' }}</h2>
                <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-700 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-300 mb-1.5 uppercase tracking-wide">Name</label>
                    <input type="text" wire:model="name" placeholder="Plan name"
                           class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-300 mb-1.5 uppercase tracking-wide">Description</label>
                    <textarea wire:model="description" rows="3" placeholder="What this plan is about…"
                              class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900 resize-none"></textarea>
                    @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror

                    </div>

                 <div>
                    <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-300 mb-1.5 uppercase tracking-wide">Price</label>
                    <input wire:model="price" placeholder="Price..." type="number" min="1" class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900 resize-none">
                                    @error('price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror

                            </div>

                 <div>
                    <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-300 mb-1.5 uppercase tracking-wide">Features</label>
                    <textarea wire:model="features" rows="4" placeholder="One feature per line"></textarea>
@error('features') <span class="error">{{ $message }}</span> @enderror
                 <div>
                    <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-300 mb-1.5 uppercase tracking-wide">Tag</label>
                    <textarea wire:model="tag" rows="3" placeholder="Tag..."
                              class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900 resize-none"></textarea>
                                    @error('tag') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror

                            </div>

            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                <button wire:click="$set('showModal', false)" class="text-sm font-semibold text-zinc-500 hover:text-zinc-900 px-4 py-2">Cancel</button>
                <button wire:click="save" wire:loading.attr="disabled"
                        class="bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-sm font-semibold px-5 py-2 rounded-lg hover:bg-zinc-700 disabled:opacity-50 transition-colors">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Save changes' : 'Create plan' }}</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Delete confirmation --}}
    <div x-data="{ show: @entangle('deletingId').live }"
         x-show="show !== null"
         x-transition:enter="transition duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;">
        <div @click.stop class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xl w-full max-w-sm p-6 text-center border border-zinc-100 dark:border-zinc-800">
            <p class="text-lg font-bold text-zinc-800 dark:text-zinc-100 mb-2">Delete plan?</p>
            <p class="text-sm text-zinc-500 mb-6">This cannot be undone.</p>
            <div class="flex justify-center gap-3">
                <button wire:click="cancelDelete" class="text-sm font-semibold text-zinc-500 hover:text-zinc-900 px-4 py-2">Cancel</button>
                <button wire:click="delete" class="bg-red-600 text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-red-700 transition-colors">Delete</button>
            </div>
        </div>
    </div>

</div>
