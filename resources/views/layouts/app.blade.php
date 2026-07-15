@if (auth()->user()->role('admin'))
    <x-layouts.app.admin-sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts.app.admin-sidebar>
@elseif (auth()->user()->role('user'))
    <x-layouts.app.user-sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts.app.user-sidebar>
@endif

