<div class="p-6 lg:p-10">

{{-- ═══════════════════════════════════ LIST VIEW ═══════════════════════════════════ --}}
@if($mode === 'list')

    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">Posts</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Manage your blog posts.</p>
        </div>
        <button wire:click="openCreate"
                class="inline-flex items-center gap-2 bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-zinc-700 dark:hover:bg-zinc-300 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Post
        </button>
    </div>

    <div class="flex flex-wrap gap-3 mb-6">
        <input wire:model.live.debounce.300ms="search"
               type="text"
               placeholder="Search posts…"
               class="border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 bg-white dark:bg-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400">
        <select wire:model.live="filterStatus"
                class="border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 bg-white dark:bg-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900">
            <option value="">All statuses</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm overflow-hidden">
        @if($posts->isEmpty())
            <div class="py-16 text-center text-zinc-400 dark:text-zinc-500 text-sm">No posts found.</div>
        @else
            <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/40">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Title</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide hidden md:table-cell">Category</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                    @foreach($posts as $post)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $post->title }}</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500">{{ $post->created_at->format('M j, Y') }}</p>
                            </td>
                            <td class="px-4 py-4 text-zinc-600 dark:text-zinc-300 hidden md:table-cell">
                                {{ $post->category?->name ?? '—' }}
                            </td>
                            <td class="px-4 py-4">
                                @if($post->status === 'published')
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full"></span> Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="openEdit({{ $post->id }})"
                                            class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors px-2 py-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $post->id }})"
                                            class="text-xs font-semibold text-red-400 hover:text-red-600 transition-colors px-2 py-1 rounded hover:bg-red-50 dark:hover:bg-red-950/30">
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
                <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800">
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
        <div class="flex flex-wrap items-center justify-between mb-6 gap-y-3">
            <div class="flex items-center gap-3">
                <button wire:click="cancel"
                    class="p-1.5 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                <span class="text-xs text-zinc-400 dark:text-zinc-500 tabular-nums">
                    <span x-text="wordCount.toLocaleString()"></span> words
                </span>

                {{-- Save status --}}
                <div class="text-xs">
                    <template x-if="saveStatus === 'saving'">
                        <span class="text-zinc-400 flex items-center gap-1">
                            <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Saving
                        </span>
                    </template>
                    <template x-if="saveStatus === 'saved'">
                        <span class="text-emerald-600/70 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    class="inline-flex items-center gap-2 bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-zinc-700 disabled:opacity-50 transition-colors">
                    <span wire:loading.remove wire:target="save">{{ $editingId ? 'Save changes' : 'Save post' }}</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>
        </div>

        {{-- 3-column editor layout --}}
        <div class="flex flex-col lg:flex-row rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm overflow-hidden bg-white dark:bg-zinc-900">

            {{-- Posts list sidebar — hidden on mobile, vertical on desktop --}}
            <aside class="hidden lg:flex w-44 shrink-0 border-r border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/60 flex-col">
                <div class="px-3 py-3 border-b border-zinc-100 dark:border-zinc-800">
                    <p class="text-[10px] uppercase tracking-widest font-semibold text-zinc-400 dark:text-zinc-500">Posts</p>
                </div>
                <nav class="flex-1 py-1 overflow-y-auto max-h-[600px]">
                    @foreach($recentPosts as $p)
                        <button wire:click="openEdit({{ $p->id }})"
                            @class([
                                'w-full flex items-center gap-2 px-3 py-2 text-left transition-colors',
                                'bg-white dark:bg-zinc-800 border-r-2 border-zinc-900 dark:border-zinc-100 text-zinc-900 dark:text-zinc-100' => $p->id === $editingId,
                                'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 hover:bg-white dark:hover:bg-zinc-800' => $p->id !== $editingId,
                            ])>
                            <span class="truncate text-[12px]">{{ $p->title ?: 'Untitled' }}</span>
                            @if($p->status === 'published')
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0 ml-auto"></span>
                            @endif
                        </button>
                    @endforeach
                </nav>
                <div class="px-3 py-3 border-t border-zinc-100 dark:border-zinc-800">
                    <button wire:click="openCreate"
                        class="w-full inline-flex items-center justify-center gap-1 bg-zinc-900 dark:bg-zinc-100 hover:bg-zinc-700 text-white dark:text-zinc-900 text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New
                    </button>
                </div>
            </aside>

            {{-- Writing area --}}
            <main class="flex-1 flex flex-col min-w-0 bg-white dark:bg-zinc-950">
                <div class="border-b border-zinc-100 dark:border-zinc-800 px-4 sm:px-6 py-4 space-y-2">
                    <input type="text" wire:model.lazy="title" placeholder="Post title"
                        class="w-full bg-transparent border-none outline-none text-xl font-bold font-serif text-zinc-900 dark:text-zinc-100 placeholder-zinc-300 dark:placeholder-zinc-600 focus:ring-0">
                    @error('title') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    <textarea wire:model.lazy="excerpt" rows="2" placeholder="Short excerpt…"
                        class="w-full bg-transparent border-none outline-none text-sm text-zinc-400 dark:text-zinc-500 placeholder-zinc-300 dark:placeholder-zinc-600 focus:ring-0 resize-none leading-relaxed"></textarea>
                </div>

                <div wire:ignore>
                    <div x-ref="quillEditor" data-initial-content="{{ $content }}"></div>
                </div>
                @error('content') <p class="px-4 sm:px-6 py-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </main>

            {{-- Meta sidebar — full-width row on mobile, fixed column on desktop --}}
            <aside class="w-full lg:w-52 shrink-0 border-t lg:border-t-0 lg:border-l border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/60 p-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-1 gap-4 lg:gap-5">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-semibold text-zinc-400 dark:text-zinc-500 mb-2">Status</label>
                    <select wire:model="status"
                        class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-semibold text-zinc-400 dark:text-zinc-500 mb-2">Category</label>
                    <select wire:model="category_id"
                        class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900">
                        <option value="">No category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if($tags->isNotEmpty())
                <div class="col-span-2 sm:col-span-3 lg:col-span-1">
                    <label class="block text-[10px] uppercase tracking-widest font-semibold text-zinc-400 dark:text-zinc-500 mb-3">Tags</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="selectedTags" value="{{ $tag->id }}"
                                    class="rounded border-zinc-300 dark:border-zinc-600 text-zinc-900 focus:ring-zinc-900">
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
     class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4"
     style="display: none;">
    <div @click.stop class="bg-white dark:bg-zinc-900 rounded-2xl shadow-xl w-full max-w-sm p-6 text-center border border-zinc-100 dark:border-zinc-800">
        <p class="text-lg font-bold text-zinc-800 dark:text-zinc-100 mb-2">Delete post?</p>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">This cannot be undone.</p>
        <div class="flex justify-center gap-3">
            <button wire:click="cancelDelete"
                    class="text-sm font-semibold text-zinc-500 hover:text-zinc-900 px-4 py-2 transition-colors">Cancel</button>
            <button wire:click="delete"
                    class="bg-red-600 text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-red-700 transition-colors">Delete</button>
        </div>
    </div>
</div>

</div>
