<div>
    @if($sent)
        <div class="py-12 text-center">
            <p class="font-display mb-4 text-2xl text-white uppercase">Message received.</p>
            <p class="mb-8 text-white/50">Thank you — I'll get back to you soon.</p>
            <button wire:click="$set('sent', false)"
                class="rounded-full border-2 border-white/30 px-6 py-2 text-sm font-bold tracking-wide text-white transition hover:border-white">
                SEND ANOTHER
            </button>
        </div>
    @else
        <form wire:submit="send" class="mt-8 mb-12 space-y-4">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <input wire:model="name"
                        class="w-full rounded-full border-2 bg-white/5 px-5 py-3.5 @error('name') border-red-500 @else border-white/20 @enderror font-medium text-white placeholder-white/40 transition focus:border-white focus:outline-none"
                        type="text" placeholder="Name" />
                    @error('name') <p class="mt-1 ml-2 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="email"
                        class="w-full rounded-full border-2 bg-white/5 px-5 py-3.5 @error('email') border-red-500 @else border-white/20 @enderror font-medium text-white placeholder-white/40 transition focus:border-white focus:outline-none"
                        type="email" placeholder="Email" />
                    @error('email') <p class="mt-1 ml-2 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <input wire:model="subject"
                    class="w-full rounded-full border-2 bg-white/5 px-5 py-3.5 @error('subject') border-red-500 @else border-white/20 @enderror font-medium text-white placeholder-white/40 transition focus:border-white focus:outline-none"
                    type="text" placeholder="Subject" />
                @error('subject') <p class="mt-1 ml-2 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <textarea wire:model="message"
                    class="w-full rounded-[1.5rem] border-2 bg-white/5 px-5 py-3.5 @error('message') border-red-500 @else border-white/20 @enderror resize-none font-medium text-white placeholder-white/40 transition focus:border-white focus:outline-none"
                    placeholder="Message" rows="6"></textarea>
                @error('message') <p class="mt-1 ml-2 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full rounded-full bg-brand py-3.5 font-bold text-white transition hover:bg-brand-dark"
                wire:loading.attr="disabled" wire:loading.class="cursor-not-allowed opacity-70">
                <span wire:loading.remove>Send</span>
                <span wire:loading>Sending…</span>
            </button>

        </form>
    @endif
</div>
