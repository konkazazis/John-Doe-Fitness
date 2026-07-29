<div class="p-6 lg:p-10">

    {{-- ═══════════════════════════════════ LIST VIEW ═══════════════════════════════════ --}}
    @if($mode === 'list')

        <div class="mb-8 flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">Posts</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Manage your blog posts.</p>
            </div>
            <button wire:click="openCreate"
                class="inline-flex items-center gap-2 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Post
            </button>
        </div>

        <div class="mb-6 flex flex-wrap gap-3">
            <input wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Search posts…"
                class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:focus:ring-zinc-400">
            <select wire:model.live="filterStatus"
                class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                <option value="">All statuses</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>

        <div class="overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @if($posts->isEmpty())
                <div class="py-16 text-center text-sm text-zinc-400 dark:text-zinc-500">No posts found.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-zinc-100 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800/40">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold tracking-wide text-zinc-500 uppercase dark:text-zinc-400">Title</th>
                                <th class="hidden px-4 py-3 text-left text-xs font-semibold tracking-wide text-zinc-500 uppercase md:table-cell dark:text-zinc-400">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-zinc-500 uppercase dark:text-zinc-400">Status</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                            @foreach($posts as $post)
                                <tr class="transition-colors hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30">
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $post->title }}</p>
                                        <p class="text-xs text-zinc-400 dark:text-zinc-500">{{ $post->created_at->format('M j, Y') }}</p>
                                    </td>
                                    <td class="hidden px-4 py-4 text-zinc-600 md:table-cell dark:text-zinc-300">
                                        {{ $post->category?->name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($post->status === 'published')
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
                                            <button wire:click="openEdit({{ $post->id }})"
                                                class="rounded px-2 py-1 text-xs font-semibold text-zinc-500 transition-colors hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-100">
                                                Edit
                                            </button>
                                            <button wire:click="confirmDelete({{ $post->id }})"
                                                class="rounded px-2 py-1 text-xs font-semibold text-red-600 dark:text-red-400 transition-colors hover:bg-red-50 hover:text-red-700 dark:hover:text-red-300 dark:hover:bg-red-950/30">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($posts->hasPages())
                    <div class="border-t border-zinc-100 px-6 py-4 dark:border-zinc-800">
                        {{ $posts->links() }}
                    </div>
                @endif
            @endif
        </div>

    {{-- ═══════════════════════════════════ EDITOR VIEW ═══════════════════════════════════ --}}
    @else

        <div
            x-data="{
                quill: null,
                wordCount: 0,
                saveStatus: '',
                saveTimer: null,

                init() {
                    this.$nextTick(() => {
                        if (typeof Quill === 'undefined' || !this.$refs.quillEditor) return;

                        this.quill = new Quill(this.$refs.quillEditor, {
                            theme: 'snow',
                            placeholder: 'Start writing your post…',
                            modules: {
                                toolbar: [
                                    [{ header: [1, 2, 3, false] }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    ['blockquote', 'code-block'],
                                    [{ list: 'ordered' }, { list: 'bullet' }],
                                    ['link', 'image'],
                                    ['clean']
                                ]
                            }
                        });

                        const initial = this.$refs.quillEditor.dataset.initialContent || '';
                        if (initial) { this.quill.root.innerHTML = initial; }
                        this.updateWordCount();

                        this.quill.on('text-change', () => {
                            this.updateWordCount();
                            this.saveStatus = '';
                            clearTimeout(this.saveTimer);
                            this.saveTimer = setTimeout(() => this.autoSave(), 800);
                        });
                    });

                    $wire.on('post-loaded', ({ content }) => {
                        if (!this.quill) return;
                        this.quill.root.innerHTML = content || '';
                        this.updateWordCount();
                        this.saveStatus = '';
                        clearTimeout(this.saveTimer);
                    });
                },

                async autoSave() {
                    this.saveStatus = 'saving';
                    await $wire.saveContent(this.quill.root.innerHTML);
                    this.saveStatus = 'saved';
                },

                updateWordCount() {
                    const text = this.quill.getText().trim();
                    this.wordCount = text ? text.split(/\s+/).filter(w => w.length > 0).length : 0;
                }
            }"
        >
            {{-- Page header --}}
            <div class="mb-6 flex flex-wrap items-center justify-between gap-y-3">
                <div class="flex items-center gap-3">
                    <button wire:click="cancel"
                        class="p-1.5 text-zinc-400 transition-colors hover:text-zinc-700 dark:hover:text-zinc-300">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">
                            {{ $editingId ? 'Edit Post' : 'New Post' }}
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    {{-- Word count --}}
                    <span class="text-xs text-zinc-400 tabular-nums dark:text-zinc-500">
                        <span x-text="wordCount.toLocaleString()"></span> words
                    </span>

                    {{-- Save status --}}
                    <div class="text-xs">
                        <template x-if="saveStatus === 'saving'">
                            <span class="flex items-center gap-1 text-zinc-400">
                                <svg class="h-3 w-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                Saving
                            </span>
                        </template>
                        <template x-if="saveStatus === 'saved'">
                            <span class="flex items-center gap-1 text-emerald-600/70">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Saved
                            </span>
                        </template>
                    </div>

                    {{-- Save button --}}
                    <button
                        @click="$wire.content = quill.root.innerHTML"
                        wire:click="save"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 disabled:opacity-50 dark:bg-zinc-100 dark:text-zinc-900">
                        <span wire:loading.remove wire:target="save">{{ $editingId ? 'Save changes' : 'Save post' }}</span>
                        <span wire:loading wire:target="save">Saving…</span>
                    </button>
                </div>
            </div>

            {{-- 3-column editor layout --}}
            <div class="flex flex-col overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-sm lg:flex-row dark:border-zinc-800 dark:bg-zinc-900">

                {{-- Posts list sidebar — hidden on mobile, vertical on desktop --}}
                <aside class="hidden w-44 shrink-0 flex-col border-r border-zinc-100 bg-zinc-50 lg:flex dark:border-zinc-800 dark:bg-zinc-900/60">
                    <div class="border-b border-zinc-100 px-3 py-3 dark:border-zinc-800">
                        <p class="text-[10px] font-semibold tracking-widest text-zinc-400 uppercase dark:text-zinc-500">Posts</p>
                    </div>
                    <nav class="max-h-[600px] flex-1 overflow-y-auto py-1">
                        @foreach($recentPosts as $p)
                            <button wire:click="openEdit({{ $p->id }})"
                                @class([
                                    'flex w-full items-center gap-2 px-3 py-2 text-left transition-colors',
                                    'border-r-2 border-zinc-900 bg-white text-zinc-900 dark:border-zinc-100 dark:bg-zinc-800 dark:text-zinc-100' => $p->id === $editingId,
                                    'text-zinc-500 hover:bg-white hover:text-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200' => $p->id !== $editingId,
                                ])>
                                <span class="truncate text-[12px]">{{ $p->title ?: 'Untitled' }}</span>
                                @if($p->status === 'published')
                                    <span class="ml-auto h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>
                                @endif
                            </button>
                        @endforeach
                    </nav>
                    <div class="border-t border-zinc-100 px-3 py-3 dark:border-zinc-800">
                        <button wire:click="openCreate"
                            class="inline-flex w-full items-center justify-center gap-1 rounded-md bg-zinc-900 px-3 py-1.5 text-xs font-medium text-white transition-colors hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            New
                        </button>
                    </div>
                </aside>

                {{-- Writing area --}}
                <main class="flex min-w-0 flex-1 flex-col bg-white dark:bg-zinc-950">
                    <div class="space-y-2 border-b border-zinc-100 px-4 py-4 sm:px-6 dark:border-zinc-800">
                        <input type="text" wire:model.lazy="title" placeholder="Post title"
                            class="w-full border-none bg-transparent font-serif text-xl font-bold text-zinc-900 placeholder-zinc-300 outline-none focus:ring-0 dark:text-zinc-100 dark:placeholder-zinc-600">
                        @error('title') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        <textarea wire:model.lazy="excerpt" rows="2" placeholder="Short excerpt…"
                            class="w-full resize-none border-none bg-transparent text-sm leading-relaxed text-zinc-400 placeholder-zinc-300 outline-none focus:ring-0 dark:text-zinc-500 dark:placeholder-zinc-600"></textarea>
                    </div>

                    <div wire:ignore>
                        <div x-ref="quillEditor" data-initial-content="{{ $content }}"></div>
                    </div>
                    @error('content') <p class="px-4 py-1 text-xs text-red-500 sm:px-6">{{ $message }}</p> @enderror
                </main>

                {{-- Meta sidebar — full-width row on mobile, fixed column on desktop --}}
                <aside class="w-full shrink-0 border-t border-zinc-100 bg-zinc-50 p-4 lg:w-52 lg:border-t-0 lg:border-l dark:border-zinc-800 dark:bg-zinc-900/60">
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-1 lg:gap-5">
                        <div>
                            <label class="mb-2 block text-[10px] font-semibold tracking-widest text-zinc-400 uppercase dark:text-zinc-500">Status</label>
                            <select wire:model="status"
                                class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-[10px] font-semibold tracking-widest text-zinc-400 uppercase dark:text-zinc-500">Category</label>
                            <select wire:model="category_id"
                                class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                                <option value="">No category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($tags->isNotEmpty())
                            <div class="col-span-2 sm:col-span-3 lg:col-span-1">
                                <label class="mb-3 block text-[10px] font-semibold tracking-widest text-zinc-400 uppercase dark:text-zinc-500">Tags</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($tags as $tag)
                                        <label class="inline-flex cursor-pointer items-center gap-2">
                                            <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}"
                                                class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900 dark:border-zinc-600">
                                            <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>{{-- end meta grid --}}
                </aside>
            </div>
        </div>

    @endif

    {{-- Delete confirmation modal --}}
    <div x-data="{ show: @entangle('deletingId').live }"
        x-show="show !== null"
        x-transition:enter="transition duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
        style="display: none;">
        <div @click.stop class="w-full max-w-sm rounded-2xl border border-zinc-100 bg-white p-6 text-center shadow-xl dark:border-zinc-800 dark:bg-zinc-900">
            <p class="mb-2 text-lg font-bold text-zinc-800 dark:text-zinc-100">Delete post?</p>
            <p class="mb-6 text-sm text-zinc-500 dark:text-zinc-400">This cannot be undone.</p>
            <div class="flex justify-center gap-3">
                <button wire:click="cancelDelete"
                    class="px-4 py-2 text-sm font-semibold text-zinc-500 transition-colors hover:text-zinc-900">Cancel</button>
                <button wire:click="delete"
                    class="rounded-lg bg-red-600 px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>

</div>
