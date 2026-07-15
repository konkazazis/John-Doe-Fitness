<x-layouts.auth.simple :title="__('Create an account')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Create an account</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Enter your details below to get started</p>
        </div>

        @if ($errors->any())
            <pre>{{ $errors }}</pre>
        @endif

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
            @csrf

            <flux:input
                name="username"
                label="Name"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="Your name"
            />
            @error('name')
            <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <flux:input
                name="email"
                label="Email address"
                :value="old('email')"
                type="email"
                required
                autocomplete="username"
                placeholder="email@example.com"
            />
            @error('email')
            <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <flux:input
                name="password"
                label="Password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Password"
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
                placeholder="Confirm password"
                viewable
            />
            @error('password_confirmation')
            <p class="-mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <flux:button variant="primary" type="submit" class="mt-2 w-full">
                Create account
            </flux:button>
        </form>

        <div class="text-center text-sm text-zinc-500 dark:text-zinc-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-zinc-900 underline dark:text-zinc-100">Log in</a>
        </div>
    </div>
</x-layouts.auth.simple>