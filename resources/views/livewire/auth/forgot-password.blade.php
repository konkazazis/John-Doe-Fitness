<x-layouts.auth.simple :title="__('Forgot password')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Reset password</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Enter your email to receive a reset link</p>
        </div>

        @if (session('status'))
            <div class="text-sm text-emerald-600 dark:text-emerald-400 text-center font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
            @csrf

            <flux:input
                name="email"
                label="Email address"
                :value="old('email')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />
            @error('email')
                <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <flux:button variant="primary" type="submit" class="w-full">
                Send reset link
            </flux:button>
        </form>

        <p class="text-sm text-center text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('login') }}" class="font-medium text-zinc-900 dark:text-zinc-100 hover:underline">
                Back to login
            </a>
        </p>
    </div>
</x-layouts.auth.simple>
