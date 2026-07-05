<x-layouts.auth.simple :title="__('Confirm password')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Confirm password</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Please confirm your password to continue</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-4">
            @csrf

            <flux:input
                name="password"
                label="Password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Your password"
                viewable
            />
            @error('password')
                <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <flux:button variant="primary" type="submit" class="w-full">
                Confirm
            </flux:button>
        </form>
    </div>
</x-layouts.auth.simple>
