<div class="p-6 lg:p-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">Overview</h1>
        <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Your portfolio at a glance.</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Published posts',    'value' => "{$publishedPosts} / {$totalPosts}",       'icon' => 'document-text'],
            ['label' => 'Published projects', 'value' => "{$publishedProjects} / {$totalProjects}", 'icon' => 'briefcase'],
            ['label' => 'Categories',         'value' => number_format($totalCategories),            'icon' => 'tag'],
            ['label' => 'Tags',               'value' => number_format($totalTags),                  'icon' => 'hashtag'],
        ] as $kpi)
            <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-zinc-100 dark:border-zinc-800 shadow-sm">
                <flux:icon :name="$kpi['icon']" class="w-5 h-5 text-zinc-400 dark:text-zinc-500 mb-3" variant="outline" />
                <div class="text-2xl font-black text-zinc-800 dark:text-zinc-100">{{ $kpi['value'] }}</div>
                <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $kpi['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent posts --}}
        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-100 dark:border-zinc-800 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-bold text-zinc-800 dark:text-zinc-100">Recent posts</h2>
                <a href="{{ route('admin.posts.index') }}" wire:navigate
                   class="text-xs font-bold text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100">View all →</a>
            </div>
            @if($recentPosts->isEmpty())
                <p class="text-sm text-zinc-400 dark:text-zinc-500 py-4">No posts yet.</p>
            @else
                <div class="space-y-3">
                    @foreach($recentPosts as $post)
                        <div class="flex items-center gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-100 truncate">{{ $post->title }}</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500">{{ $post->status }}</p>
                            </div>
                            <span class="text-xs text-zinc-300 dark:text-zinc-600 shrink-0">{{ $post->created_at->diffForHumans(null, true) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
