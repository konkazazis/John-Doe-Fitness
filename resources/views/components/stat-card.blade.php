@props(['label', 'value', 'unit' => null, 'hint' => null, 'accent' => 'emerald'])

@php
$accents = [
    'emerald' => 'text-emerald-600 dark:text-emerald-400',
    'sky'     => 'text-sky-600 dark:text-sky-400',
    'amber'   => 'text-amber-600 dark:text-amber-400',
    'rose'    => 'text-rose-600 dark:text-rose-400',
];
$accentClass = $accents[$accent] ?? $accents['emerald'];
@endphp

<div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800/70 dark:bg-zinc-900/50">
    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">{{ $label }}</p>
    <p class="mt-2 flex items-baseline gap-1">
        <span class="text-2xl font-semibold text-zinc-800 dark:text-white">{{ $value }}</span>
        @if($unit)
            <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $unit }}</span>
        @endif
    </p>
    @if($hint)
        <p class="mt-1.5 text-xs {{ $accentClass }}">{{ $hint }}</p>
    @endif
</div>
