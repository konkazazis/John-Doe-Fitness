<x-layouts.auth.simple :title="__('Create an account')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <span class="section-label mb-1 text-center">Join us</span>
            <h1 class="font-display text-3xl text-ink uppercase">Create an account</h1>
            <p class="mt-2 text-sm text-ink/60">Enter your details below to get started</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
            @csrf

            <div>
                <input
                    name="username"
                    value="{{ old('name') }}"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Your name"
                    class="w-full rounded-full border-2 bg-cream px-5 py-3.5 font-medium text-ink placeholder-ink/40 transition focus:border-ink focus:outline-none @error('name') border-red-500 @else border-ink/15 @enderror"
                >
                @error('name')
                    <p class="mt-1 ml-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input
                    name="email"
                    value="{{ old('email') }}"
                    type="email"
                    required
                    autocomplete="username"
                    placeholder="Email address"
                    class="w-full rounded-full border-2 bg-cream px-5 py-3.5 font-medium text-ink placeholder-ink/40 transition focus:border-ink focus:outline-none @error('email') border-red-500 @else border-ink/15 @enderror"
                >
                @error('email')
                    <p class="mt-1 ml-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{ show: false }">
                <div class="relative">
                    <input
                        name="password"
                        :type="show ? 'text' : 'password'"
                        required
                        autocomplete="new-password"
                        placeholder="Password"
                        class="w-full rounded-full border-2 bg-cream px-5 py-3.5 pr-12 font-medium text-ink placeholder-ink/40 transition focus:border-ink focus:outline-none @error('password') border-red-500 @else border-ink/15 @enderror"
                    >
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-4 flex items-center text-ink/40 hover:text-ink">
                        <svg x-show="!show" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <svg x-show="show" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 ml-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm password"
                    class="w-full rounded-full border-2 bg-cream px-5 py-3.5 font-medium text-ink placeholder-ink/40 transition focus:border-ink focus:outline-none @error('password_confirmation') border-red-500 @else border-ink/15 @enderror"
                >
                @error('password_confirmation')
                    <p class="mt-1 ml-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="mt-2 w-full rounded-full bg-ink py-3.5 font-bold text-white transition-colors hover:bg-ink/80">
                Create account
            </button>
        </form>

        <div class="text-center text-sm text-ink/60">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-ink hover:text-brand">Log in</a>
        </div>
    </div>
</x-layouts.auth.simple>
