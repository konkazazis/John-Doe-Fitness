<div>
    @if($sent)
        <div class="text-center py-12">
            <p class="font-serif text-2xl text-white mb-4">Message received.</p>
            <p class="text-stone-400 mb-8">Thank you — I'll get back to you soon.</p>
            <button wire:click="$set('sent', false)"
                class="text-sm font-medium text-stone-400 border border-stone-700 px-6 py-2 hover:border-stone-500 transition tracking-wide">
                SEND ANOTHER
            </button>
        </div>
    @else
        <form wire:submit="send" class="space-y-6 mb-12">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <input wire:model="name"
                        class="w-full px-4 py-3 bg-stone-800 border @error('name') border-red-500 @else border-stone-700 @enderror text-white placeholder-stone-500 focus:outline-none focus:border-white transition"
                        type="text" placeholder="Name" />
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="email"
                        class="w-full px-4 py-3 bg-stone-800 border @error('email') border-red-500 @else border-stone-700 @enderror text-white placeholder-stone-500 focus:outline-none focus:border-white transition"
                        type="email" placeholder="Email" />
                    @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <input wire:model="subject"
                    class="w-full px-4 py-3 bg-stone-800 border @error('subject') border-red-500 @else border-stone-700 @enderror text-white placeholder-stone-500 focus:outline-none focus:border-white transition"
                    type="text" placeholder="Subject" />
                @error('subject') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <textarea wire:model="message"
                    class="w-full px-4 py-3 bg-stone-800 border @error('message') border-red-500 @else border-stone-700 @enderror text-white placeholder-stone-500 focus:outline-none focus:border-white transition resize-none"
                    placeholder="Message" rows="6"></textarea>
                @error('message') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full py-3 bg-white text-stone-900 font-semibold hover:bg-stone-100 transition"
                wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed">
                <span wire:loading.remove>Send</span>
                <span wire:loading>Sending…</span>
            </button>

        </form>
    @endif
</div>
