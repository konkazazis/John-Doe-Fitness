<x-layouts.auth.simple :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Welcome back</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Sign in to your account</p>
        </div>

        @if (session('status'))
            <div class="text-sm text-emerald-600 dark:text-emerald-400 text-center font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
            @csrf

            <flux:input
                name="email"
                label="Email address"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />
            @error('email')
                <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <div class="relative">
                <flux:input
                    name="password"
                    label="Password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                    viewable
                />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="absolute top-0 inset-e-0 text-xs text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100">
                        Forgot password?
                    </a>
                @endif
            </div>
            @error('password')
                <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <flux:checkbox name="remember" label="Remember me" :checked="old('remember')" />

            <flux:button variant="primary" type="submit" class="w-full mt-2">
                Log in
            </flux:button>
        </form>
    </div>
</x-layouts.auth.simple>
