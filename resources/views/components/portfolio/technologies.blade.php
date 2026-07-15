@php
    $items = ['NASM-CPT Certified', 'Precision Nutrition L1', 'ISSA Strength Coach', 'Trainerize', 'MacroFactor', 'CPR / AED Certified'];
@endphp

<section class="overflow-hidden border-y border-stone-200 bg-white py-16">
    <p class="section-label mb-8 text-center">Credentials &amp; tools</p>

    <div class="relative">
        <div
            class="flex animate-[marquee_28s_linear_infinite] gap-12 whitespace-nowrap"
            style="width: max-content"
        >
            @foreach (array_merge($items, $items) as $item)
                <span
                    class="font-display shrink-0 text-2xl font-semibold text-stone-300"
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
