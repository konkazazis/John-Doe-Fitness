<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-cream font-sans text-ink antialiased">
    <div class="dotgrid relative flex min-h-svh flex-col items-center justify-center gap-8 p-6 md:p-10">
        <a href="{{ route('home') }}" class="relative flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand text-base font-black text-white">
                J
            </span>
            <span class="font-display text-lg tracking-tight text-ink uppercase">
                John&nbsp;Doe
            </span>
        </a>

        <div class="panel-card relative w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
