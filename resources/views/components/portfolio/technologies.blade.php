@php
    $items = ["NASM-CPT Certified", "Precision Nutrition L1", "ISSA Strength Coach", "Trainerize", "MacroFactor", "CPR / AED Certified"];
@endphp

<section class="py-16 bg-white border-y border-stone-200 overflow-hidden">
    <p class="text-center section-label mb-8">Credentials &amp; tools</p>

    <div class="relative">
        <div
            class="flex gap-12 whitespace-nowrap animate-[marquee_28s_linear_infinite]"
            style="width: max-content"
        >
            @foreach (array_merge($items, $items) as $item)
                <span
                    class="font-display text-2xl font-semibold text-stone-300 shrink-0"
                >
                    {{ $item }}
                </span>
            @endforeach
        </div>
    </div>
</section>

@once
    @push("styles")
        <style>
            @keyframes marquee {
                from {
                    transform: translateX(0);
                }
                to {
                    transform: translateX(-50%);
                }
            }
            @media (prefers-reduced-motion: reduce) {
                .animate-\[marquee_28s_linear_infinite\] {
                    animation: none;
                }
            }
        </style>
    @endpush
@endonce
