<x-layouts.auth.simple :title="__('Reset password')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">New password</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Choose a strong password</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <flux:input
                name="email"
                label="Email address"
                :value="old('email', $request->email)"
                type="email"
                required
                autocomplete="email"
            />
            @error('email')
            <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <flux:input
                name="password"
                label="New password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="At least 8 characters"
                viewable
            />
            @error('password')
            <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <flux:input
                name="password_confirmation"
                label="Confirm password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Repeat password"
                viewable
            />

            <flux:button variant="primary" type="submit" class="w-full">
                Reset password
            </flux:button>
        </form>
    </div>
</x-layouts.auth.simple>
