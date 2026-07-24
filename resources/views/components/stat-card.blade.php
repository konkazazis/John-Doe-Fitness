@props(['label', 'value', 'unit' => null, 'hint' => null, 'accent' => 'emerald'])

@php
$accents = [
    'emerald' => 'text-emerald-400',
    'sky'     => 'text-sky-400',
    'amber'   => 'text-amber-400',
    'rose'    => 'text-rose-400',
];
$accentClass = $accents[$accent] ?? $accents['emerald'];
@endphp

<div class="rounded-2xl border border-zinc-800/70 bg-zinc-900/50 p-5">
    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500">{{ $label }}</p>
    <p class="mt-2 flex items-baseline gap-1">
        <span class="text-2xl font-semibold text-white">{{ $value }}</span>
        @if($unit)
            <span class="text-sm text-zinc-500">{{ $unit }}</span>
        @endif
    </p>
    @if($hint)
        <p class="mt-1.5 text-xs {{ $accentClass }}">{{ $hint }}</p>
    @endif
</div>