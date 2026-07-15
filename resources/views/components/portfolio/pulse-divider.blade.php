@props(['color' => 'brand'])

@php
    $stroke = $color === 'sprout' ? '#4c7a3f' : '#eb5424';
@endphp

<div {{ $attributes->class('w-full overflow-hidden py-2') }} aria-hidden="true">
    <svg viewBox="0 0 400 24" preserveAspectRatio="none" class="h-6 w-full">
        <polyline
            points="0,12 140,12 155,2 168,22 182,4 194,20 206,12 400,12"
            fill="none"
            stroke="{{ $stroke }}"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
            opacity="0.5"
        />
    </svg>
</div>