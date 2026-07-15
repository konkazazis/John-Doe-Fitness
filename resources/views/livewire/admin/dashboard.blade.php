<div class="p-6 lg:p-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">Overview</h1>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Your portfolio at a glance.</p>
    </div>

    {{-- KPI Cards --}}
    <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach([
                ['label' => 'Published posts',    'value' => "{$publishedPosts} / {$totalPosts}",       'icon' => 'document-text'],
                ['label' => 'Published projects', 'value' => "{$publishedProjects} / {$totalProjects}", 'icon' => 'briefcase'],
                ['label' => 'Categories',         'value' => number_format($totalCategories),            'icon' => 'tag'],
                ['label' => 'Tags',               'value' => number_format($totalTags),                  'icon' => 'hashtag'],
            ] as $kpi)
            <div class="rounded-2xl border border-zinc-100 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <flux:icon :name="$kpi['icon']" class="mb-3 h-5 w-5 text-zinc-400 dark:text-zinc-500" variant="outline" />
                <div class="text-2xl font-black text-zinc-800 dark:text-zinc-100">{{ $kpi['value'] }}</div>
                <div class="mt-0.5 text-xs font-semibold text-zinc-500 dark:text-zinc-400">{{ $kpi['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- Recent posts --}}
        <div class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-base font-bold text-zinc-800 dark:text-zinc-100">Recent posts</h2>
                <a href="{{ route('admin.posts.index') }}" wire:navigate
                    class="text-xs font-bold text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">View all →</a>
            </div>
            @if($recentPosts->isEmpty())
                <p class="py-4 text-sm text-zinc-400 dark:text-zinc-500">No posts yet.</p>
            @else
                <div class="space-y-3">
                    @foreach($recentPosts as $post)
                        <div class="flex items-center gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $post->title }}</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500">{{ $post->status }}</p>
                            </div>
                            <span class="shrink-0 text-xs text-zinc-300 dark:text-zinc-600">{{ $post->created_at->diffForHumans(null, true) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
