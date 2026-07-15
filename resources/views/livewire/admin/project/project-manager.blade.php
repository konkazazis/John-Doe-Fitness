<div class="p-6 lg:p-10">

    <div class="mb-8 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">Projects</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Manage your portfolio projects.</p>
        </div>
        <button wire:click="openCreate"
            class="inline-flex items-center gap-2 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Project
        </button>
    </div>

    <div class="mb-6">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search projects…"
            class="w-full max-w-xs rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
    </div>

    <div class="overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        @if($projects->isEmpty())
            <div class="py-16 text-center text-sm text-zinc-400 dark:text-zinc-500">No projects yet.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-zinc-100 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800/40">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-zinc-500 uppercase">Title</th>
                            <th class="hidden px-4 py-3 text-left text-xs font-semibold tracking-wide text-zinc-500 uppercase md:table-cell">Technologies</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-zinc-500 uppercase">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @foreach($projects as $project)
                            <tr class="transition-colors hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($project->coverUrl())
                                            <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}"
                                                class="h-10 w-10 shrink-0 rounded-md object-cover">
                                        @else
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-zinc-100 dark:bg-zinc-800">
                                                <svg class="h-5 w-5 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $project->title }}</p>
                                            <p class="text-xs text-zinc-400 dark:text-zinc-500">{{ $project->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden px-4 py-4 text-xs text-zinc-500 md:table-cell dark:text-zinc-400">
                                    {{ $project->technologies ?? '—' }}
                                </td>
                                <td class="px-4 py-4">
                                    @if($project->is_published)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-zinc-100 px-2 py-0.5 text-xs font-semibold text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-zinc-400"></span> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="openEdit({{ $project->id }})"
                                            class="rounded px-2 py-1 text-xs font-semibold text-zinc-500 transition-colors hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800">Edit</button>
                                        <button wire:click="confirmDelete({{ $project->id }})"
                                            class="rounded px-2 py-1 text-xs font-semibold text-red-400 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/30">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($projects->hasPages())
                <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">{{ $projects->links() }}</div>
            @endif
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    <div x-data="{ show: @entangle('showModal').live }"
        x-show="show"
        x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @keydown.escape.window="$wire.showModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
        style="display: none;">
        <div @click.stop
            class="max-h-[90vh] w-full max-w-xl overflow-y-auto rounded-2xl border border-zinc-100 bg-white p-6 shadow-xl dark:border-zinc-800 dark:bg-zinc-900"
            x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">{{ $editingId ? 'Edit Project' : 'New Project' }}</h2>
                <button wire:click="$set('showModal', false)" class="p-1 text-zinc-400 hover:text-zinc-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Title</label>
                    <input type="text" wire:model="title" placeholder="Project title"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                    @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Description</label>
                    <textarea wire:model="description" rows="3" placeholder="What this project is about…"
                        class="w-full resize-none rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100"></textarea>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Cover Image</label>
                    <input type="file" wire:model="cover" accept="image/*"
                        class="w-full text-sm text-zinc-600 file:mr-3 file:cursor-pointer file:rounded-lg file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-300 dark:file:bg-zinc-800 dark:file:text-zinc-300 dark:hover:file:bg-zinc-700">
                    @error('cover') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="cover" class="mt-1 text-xs text-zinc-400">Uploading…</div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="is_published" id="proj_is_published"
                        class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900 dark:border-zinc-600">
                    <label for="proj_is_published" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Published</label>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                <button wire:click="$set('showModal', false)" class="px-4 py-2 text-sm font-semibold text-zinc-500 hover:text-zinc-900">Cancel</button>
                <button wire:click="save" wire:loading.attr="disabled"
                    class="rounded-lg bg-zinc-900 px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 disabled:opacity-50 dark:bg-zinc-100 dark:text-zinc-900">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Save changes' : 'Create project' }}</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Delete confirmation --}}
    <div x-data="{ show: @entangle('deletingId').live }"
        x-show="show !== null"
        x-transition:enter="transition duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
        style="display: none;">
        <div @click.stop class="w-full max-w-sm rounded-2xl border border-zinc-100 bg-white p-6 text-center shadow-xl dark:border-zinc-800 dark:bg-zinc-900">
            <p class="mb-2 text-lg font-bold text-zinc-800 dark:text-zinc-100">Delete project?</p>
            <p class="mb-6 text-sm text-zinc-500">This cannot be undone.</p>
            <div class="flex justify-center gap-3">
                <button wire:click="cancelDelete" class="px-4 py-2 text-sm font-semibold text-zinc-500 hover:text-zinc-900">Cancel</button>
                <button wire:click="delete" class="rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>

</div>
