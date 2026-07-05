<section id="pricing" class="py-24 bg-stone-50">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex flex-col items-center text-center mb-12">
            <span class="section-label">Coaching plans</span>
            <h2 class="section-heading">Pick your pace</h2>
            <p class="text-stone-600 text-lg max-w-xl mb-8">
                Every plan includes both training and nutrition coaching. Annual
                billing works out to roughly two months free.
            </p>

            {{-- Billing toggle --}}
            <div
                class="inline-flex items-center rounded-full border border-stone-300 bg-white p-1"
            >
                {{--
                    <button
                    wire:click="setPeriod('monthly')"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-colors {{ $period === "monthly" ? "bg-[#eb5424] text-white" : "text-stone-600" }}"
                    >
                    Monthly
                    </button>
                    <button
                    wire:click="setPeriod('annual')"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-colors {{ $period === "annual" ? "bg-[#eb5424] text-white" : "text-stone-600" }}"
                    >
                    Annual
                    <span class="ml-1 text-xs opacity-80">save ~20%</span>
                    </button>
                --}}
            </div>
        </div>

        {{--
            <div class="grid md:grid-cols-3 gap-6 items-stretch">
            @foreach ($plans as $plan)
            @php
            $isFuel = $plan["group"] === "fuel";
            @endphp
            
            <div
            class="panel-card flex flex-col {{ $plan["featured"] ?? false ? "ring-2 ring-[#eb5424] relative" : "" }}"
            >
            @if ($plan["featured"] ?? false)
            <span class="absolute -top-3 left-8 category-badge">
            Most popular
            </span>
            @endif
            
            <span
            class="{{ $isFuel ? "tag-badge-sprout" : "tag-badge" }}"
            >
            {{ $isFuel ? "Train + Fuel" : "Train" }}
            </span>
            
            <h3
            class="font-display text-2xl font-bold text-stone-900 mt-4"
            >
            {{ $plan["name"] }}
            </h3>
            <p class="text-stone-600 mt-2 mb-6">
            {{ $plan["blurb"] }}
            </p>
            
            <div class="mb-6">
            <span
            class="font-display text-4xl font-bold text-stone-900 tabular-nums"
            >
            ${{ $period === "annual" ? $plan["annual"] : $plan["monthly"] }}
            </span>
            <span class="text-stone-500">/month</span>
            @if ($period === "annual")
            <p class="text-xs text-stone-500 mt-1">
            billed annually
            </p>
            @endif
            </div>
            
            <ul class="space-y-3 mb-8 flex-1">
            @foreach ($plan["features"] as $feature)
            <li
            class="flex items-start gap-2 text-sm text-stone-700"
            >
            <svg
            class="w-4 h-4 mt-0.5 flex-shrink-0 {{ $isFuel ? "text-[#4c7a3f]" : "text-[#eb5424]" }}"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            >
            <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M5 13l4 4L19 7"
            />
            </svg>
            {{ $feature }}
            </li>
            @endforeach
            </ul>
            
            <a
            href="#contact"
            class="smoothScroll text-center rounded-full px-6 py-3 text-sm font-semibold transition-colors {{ $plan["featured"] ?? false ? "bg-[#eb5424] text-white hover:bg-[#c94219]" : "border border-stone-300 text-stone-800 hover:border-stone-400" }}"
            >
            Start with {{ $plan["name"] }}
            </a>
            </div>
            @endforeach
            </div>
        --}}
    </div>
</section>
