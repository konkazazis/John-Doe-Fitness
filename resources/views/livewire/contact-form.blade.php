<div>
    @if($sent)
        <div class="py-12 text-center">
            <p class="mb-4 font-serif text-2xl text-white">Message received.</p>
            <p class="mb-8 text-stone-400">Thank you — I'll get back to you soon.</p>
            <button wire:click="$set('sent', false)"
                class="border border-stone-700 px-6 py-2 text-sm font-medium tracking-wide text-stone-400 transition hover:border-stone-500">
                SEND ANOTHER
            </button>
        </div>
    @else
        <form wire:submit="send" class="mb-12 space-y-6">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <input wire:model="name"
                        class="w-full border bg-stone-800 px-4 py-3 @error('name') border-red-500 @else border-stone-700 @enderror text-white placeholder-stone-500 transition focus:border-white focus:outline-none"
                        type="text" placeholder="Name" />
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="email"
                        class="w-full border bg-stone-800 px-4 py-3 @error('email') border-red-500 @else border-stone-700 @enderror text-white placeholder-stone-500 transition focus:border-white focus:outline-none"
                        type="email" placeholder="Email" />
                    @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <input wire:model="subject"
                    class="w-full border bg-stone-800 px-4 py-3 @error('subject') border-red-500 @else border-stone-700 @enderror text-white placeholder-stone-500 transition focus:border-white focus:outline-none"
                    type="text" placeholder="Subject" />
                @error('subject') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <textarea wire:model="message"
                    class="w-full border bg-stone-800 px-4 py-3 @error('message') border-red-500 @else border-stone-700 @enderror resize-none text-white placeholder-stone-500 transition focus:border-white focus:outline-none"
                    placeholder="Message" rows="6"></textarea>
                @error('message') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full bg-white py-3 font-semibold text-stone-900 transition hover:bg-stone-100"
                wire:loading.attr="disabled" wire:loading.class="cursor-not-allowed opacity-70">
                <span wire:loading.remove>Send</span>
                <span wire:loading>Sending…</span>
            </button>

        </form>
    @endif
</div>
