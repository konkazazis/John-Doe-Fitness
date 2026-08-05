<div class="p-6 lg:p-10">

    <div class="mb-8 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">
                Client Messages
                @if($unreadCount > 0)
                    <span class="ml-2 rounded-full bg-red-100 px-2 py-0.5 text-sm font-semibold text-red-600 dark:bg-red-950/50 dark:text-red-400">{{ $unreadCount }} new</span>
                @endif
            </h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Conversations with your clients.</p>
        </div>
        <button wire:click="openNew"
            class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
            New message
        </button>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

        {{-- Conversation list --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                @if($conversations->isEmpty())
                    <div class="py-16 text-center text-sm text-zinc-400 dark:text-zinc-500">No conversations yet.</div>
                @else
                    <div class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @foreach($conversations as $client)
                            <button wire:click="view({{ $client->id }})"
                                class="w-full px-5 py-4 text-left transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50 {{ $viewing === $client->id ? 'bg-zinc-50 dark:bg-zinc-800/50' : '' }}">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            @if($client->unread_count > 0)
                                                <span class="h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                                            @endif
                                            <p class="truncate text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $client->username }}</p>
                                        </div>
                                        <p class="mt-0.5 truncate text-xs text-zinc-400 dark:text-zinc-500">{{ $client->email }}</p>
                                    </div>
                                    <p class="shrink-0 text-xs text-zinc-400 dark:text-zinc-500">{{ \Illuminate\Support\Carbon::parse($client->client_messages_max_created_at)->diffForHumans(null, true) }}</p>
                                </div>
                            </button>
                        @endforeach
                    </div>
                    @if($conversations->hasPages())
                        <div class="border-t border-zinc-100 px-5 py-3 dark:border-zinc-800">
                            {{ $conversations->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Thread --}}
        <div class="lg:col-span-3">
            @if($currentUser)
                <div wire:poll.10s class="flex h-[32rem] flex-col overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex items-center justify-between border-b border-zinc-100 px-6 py-4 dark:border-zinc-800">
                        <div>
                            <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">{{ $currentUser->username }}</h2>
                            <a href="mailto:{{ $currentUser->email }}" class="text-sm text-blue-500 hover:underline">{{ $currentUser->email }}</a>
                        </div>
                        <button wire:click="deleteConversation({{ $currentUser->id }})"
                            wire:confirm="Delete this entire conversation?"
                            class="rounded p-1.5 text-zinc-400 transition-colors hover:bg-red-50 hover:text-red-500 dark:text-zinc-500 dark:hover:bg-red-950/30">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 space-y-4 overflow-y-auto p-6">
                        @forelse($thread as $msg)
                            <div class="flex {{ $msg->sender === 'admin' ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-md rounded-2xl px-4 py-2.5 text-sm {{ $msg->sender === 'admin' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200' }}">
                                    <p class="leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                                    <p class="mt-1 text-[10px] opacity-60">{{ $msg->created_at->format('M j, g:i A') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="flex h-full items-center justify-center text-sm text-zinc-400 dark:text-zinc-500">No messages yet.</div>
                        @endforelse
                    </div>

                    <form wire:submit="send" class="border-t border-zinc-100 p-4 dark:border-zinc-800">
                        <div class="flex items-end gap-3">
                            <textarea wire:model="reply" rows="1"
                                class="flex-1 resize-none rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-400 transition-colors focus:border-zinc-400 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100"
                                placeholder="Write a reply…"></textarea>
                            <button type="submit"
                                class="shrink-0 rounded-xl bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 disabled:opacity-50 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>Send</span>
                                <span wire:loading>Sending…</span>
                            </button>
                        </div>
                        @error('reply') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </form>
                </div>
            @else
                <div class="flex items-center justify-center rounded-2xl border border-zinc-100 bg-white py-16 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <p class="text-sm text-zinc-400 dark:text-zinc-500">Select a conversation to read it</p>
                </div>
            @endif
        </div>
    </div>

    {{-- New message modal --}}
    <div x-data="{ show: @entangle('showNewModal').live }"
        x-show="show"
        x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @keydown.escape.window="$wire.showNewModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
        style="display: none;">
        <div @click.stop
            class="w-full max-w-md rounded-2xl border border-zinc-100 bg-white p-6 shadow-xl dark:border-zinc-800 dark:bg-zinc-900"
            x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">New Message</h2>
                <button wire:click="$set('showNewModal', false)" class="p-1 text-zinc-400 hover:text-zinc-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Client</label>
                    <select wire:model="newUserId"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100">
                        <option value="">Select a client…</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->username }} ({{ $client->email }})</option>
                        @endforeach
                    </select>
                    @error('newUserId') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold tracking-wide text-zinc-600 uppercase dark:text-zinc-300">Message</label>
                    <textarea wire:model="newMessage" rows="4" placeholder="Write your message…"
                        class="w-full resize-none rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-800 placeholder-zinc-400 focus:ring-2 focus:ring-zinc-900 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100"></textarea>
                    @error('newMessage') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mt-6 flex justify-end gap-3 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    <button wire:click="$set('showNewModal', false)" class="px-4 py-2 text-sm font-semibold text-zinc-500 hover:text-zinc-900">Cancel</button>
                    <button wire:click="startConversation" wire:loading.attr="disabled"
                        class="rounded-lg bg-zinc-900 px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 disabled:opacity-50 dark:bg-zinc-100 dark:text-zinc-900">
                        <span wire:loading.remove wire:target="startConversation">Send</span>
                        <span wire:loading wire:target="startConversation">Sending…</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
