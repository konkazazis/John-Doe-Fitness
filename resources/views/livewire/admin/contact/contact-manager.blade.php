<div class="p-6 lg:p-10">

    <div class="mb-8 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">
                Messages
                @if($unreadCount > 0)
                    <span class="ml-2 rounded-full bg-red-100 px-2 py-0.5 text-sm font-semibold text-red-600 dark:bg-red-950/50 dark:text-red-400">{{ $unreadCount }} new</span>
                @endif
            </h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Contact form submissions from your portfolio.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

        {{-- Message list --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                @if($messages->isEmpty())
                    <div class="py-16 text-center text-sm text-zinc-400 dark:text-zinc-500">No messages yet.</div>
                @else
                    <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @foreach($messages as $msg)
                            <button wire:click="view({{ $msg->id }})"
                                class="w-full px-5 py-4 text-left transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50 {{ $viewing === $msg->id ? 'bg-zinc-50 dark:bg-zinc-800/50' : '' }}">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            @if(!$msg->is_read)
                                                <span class="h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                                            @endif
                                            <p class="truncate text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $msg->name }}</p>
                                        </div>
                                        <p class="mt-0.5 truncate text-xs text-zinc-400 dark:text-zinc-500">{{ $msg->subject ?: $msg->email }}</p>
                                    </div>
                                    <p class="shrink-0 text-xs text-zinc-400 dark:text-zinc-500">{{ $msg->created_at->diffForHumans(null, true) }}</p>
                                </div>
                            </button>
                        @endforeach
                    </div>
                    @if($messages->hasPages())
                        <div class="border-t border-zinc-100 px-5 py-3 dark:border-zinc-800">
                            {{ $messages->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Message detail --}}
        <div class="lg:col-span-3">
            @if($current)
                <div class="rounded-2xl border border-zinc-100 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="mb-6 flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">{{ $current->name }}</h2>
                            <a href="mailto:{{ $current->email }}" class="text-sm text-blue-500 hover:underline">{{ $current->email }}</a>
                            @if($current->subject)
                                <p class="mt-1 text-xs text-zinc-400 dark:text-zinc-500">Re: {{ $current->subject }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="text-xs text-zinc-400 dark:text-zinc-500">{{ $current->created_at->format('M j, Y') }}</p>
                            <button wire:click="delete({{ $current->id }})"
                                wire:confirm="Delete this message?"
                                class="rounded p-1.5 text-zinc-400 transition-colors hover:bg-red-50 hover:text-red-500 dark:text-zinc-500 dark:hover:bg-red-950/30">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="prose prose-sm max-w-none border-t border-zinc-100 pt-5 leading-relaxed text-zinc-600 dark:border-zinc-800 dark:text-zinc-300">
                        {!! nl2br(e($current->message)) !!}
                    </div>

                    <div class="mt-6 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                        <a href="mailto:{{ $current->email }}?subject=Re: {{ $current->subject ?? 'Your enquiry' }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                            Reply via email
                        </a>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-center rounded-2xl border border-zinc-100 bg-white py-16 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm text-zinc-400 dark:text-zinc-500">Select a message to read it</p>
                </div>
            @endif
        </div>
    </div>

</div>
