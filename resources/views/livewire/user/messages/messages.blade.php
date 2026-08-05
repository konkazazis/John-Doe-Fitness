<div class="p-6 lg:p-10">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-800 dark:text-zinc-100">Messages</h1>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Chat directly with your coach.</p>
    </div>

    <div wire:poll.10s class="flex h-[70vh] flex-col overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">

        <div class="flex-1 space-y-4 overflow-y-auto p-6">
            @forelse($messages as $msg)
                <div class="flex {{ $msg->sender === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-md rounded-2xl px-4 py-2.5 text-sm {{ $msg->sender === 'user' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200' }}">
                        <p class="leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                        <p class="mt-1 text-[10px] opacity-60">{{ $msg->created_at->format('M j, g:i A') }}</p>
                    </div>
                </div>
            @empty
                <div class="flex h-full items-center justify-center text-sm text-zinc-400 dark:text-zinc-500">
                    No messages yet. Send a message to get started.
                </div>
            @endforelse
        </div>

        <form wire:submit="send" class="border-t border-zinc-100 p-4 dark:border-zinc-800">
            <div class="flex items-end gap-3">
                <textarea wire:model="message" rows="1"
                    class="flex-1 resize-none rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-800 placeholder-zinc-400 transition-colors focus:border-zinc-400 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100"
                    placeholder="Write a message…"></textarea>
                <button type="submit"
                    class="shrink-0 rounded-xl bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-zinc-700 disabled:opacity-50 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Send</span>
                    <span wire:loading>Sending…</span>
                </button>
            </div>
            @error('message') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </form>
    </div>

</div>
