<div class="p-6 lg:p-10">

    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">
                Messages
                @if($unreadCount > 0)
                    <span class="ml-2 text-sm font-semibold bg-red-100 dark:bg-red-950/50 text-red-600 dark:text-red-400 px-2 py-0.5 rounded-full">{{ $unreadCount }} new</span>
                @endif
            </h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Contact form submissions from your portfolio.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Message list --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm overflow-hidden">
                @if($messages->isEmpty())
                    <div class="py-16 text-center text-zinc-400 dark:text-zinc-500 text-sm">No messages yet.</div>
                @else
                    <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @foreach($messages as $msg)
                            <button wire:click="view({{ $msg->id }})"
                                    class="w-full text-left px-5 py-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ $viewing === $msg->id ? 'bg-zinc-50 dark:bg-zinc-800/50' : '' }}">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            @if(!$msg->is_read)
                                                <span class="w-2 h-2 bg-blue-500 rounded-full shrink-0"></span>
                                            @endif
                                            <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-100 truncate">{{ $msg->name }}</p>
                                        </div>
                                        <p class="text-xs text-zinc-400 dark:text-zinc-500 truncate mt-0.5">{{ $msg->subject ?: $msg->email }}</p>
                                    </div>
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 shrink-0">{{ $msg->created_at->diffForHumans(null, true) }}</p>
                                </div>
                            </button>
                        @endforeach
                    </div>
                    @if($messages->hasPages())
                        <div class="px-5 py-3 border-t border-zinc-100 dark:border-zinc-800">
                            {{ $messages->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Message detail --}}
        <div class="lg:col-span-3">
            @if($current)
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">{{ $current->name }}</h2>
                            <a href="mailto:{{ $current->email }}" class="text-sm text-blue-500 hover:underline">{{ $current->email }}</a>
                            @if($current->subject)
                                <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Re: {{ $current->subject }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="text-xs text-zinc-400 dark:text-zinc-500">{{ $current->created_at->format('M j, Y') }}</p>
                            <button wire:click="delete({{ $current->id }})"
                                    wire:confirm="Delete this message?"
                                    class="p-1.5 text-zinc-400 dark:text-zinc-500 hover:text-red-500 transition-colors rounded hover:bg-red-50 dark:hover:bg-red-950/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="prose prose-sm max-w-none text-zinc-600 dark:text-zinc-300 leading-relaxed border-t border-zinc-100 dark:border-zinc-800 pt-5">
                        {!! nl2br(e($current->message)) !!}
                    </div>

                    <div class="mt-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <a href="mailto:{{ $current->email }}?subject=Re: {{ $current->subject ?? 'Your enquiry' }}"
                           class="inline-flex items-center gap-2 bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-zinc-700 dark:hover:bg-zinc-300 transition-colors">
                            Reply via email
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm py-16 flex items-center justify-center">
                    <p class="text-sm text-zinc-400 dark:text-zinc-500">Select a message to read it</p>
                </div>
            @endif
        </div>
    </div>

</div>
