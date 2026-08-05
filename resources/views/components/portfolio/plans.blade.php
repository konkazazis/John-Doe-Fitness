<section id="pricing" class="relative overflow-hidden bg-ink py-24">
    <div class="absolute inset-0 dotgrid-light opacity-30"></div>
    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-14 flex flex-col items-center text-center">
            <span class="section-label">Coaching plans</span>
            <h2 class="section-heading text-white">Pick your plan</h2>
            <p class="max-w-xl text-lg text-white/60">
                Every plan includes both training and nutrition coaching.
            </p>
        </div>

        <div class="grid items-stretch gap-6 md:grid-cols-3">
            @foreach ($plans as $plan)
                @php
                    $isFuel = $plan['group'] === 'fuel';
                    $isFeatured = $plan['featured'] ?? false;
                @endphp

                <div
                    class="relative flex flex-col rounded-[2rem] p-8 {{ $isFeatured ? "-translate-y-2 bg-brand" : "bg-charcoal" }}"
                >
                    @if ($isFeatured)
                        <span
                            class="absolute top-0 right-8 -translate-y-1/2 rounded-full bg-ink px-4 py-1 text-xs font-bold text-white"
                        >
                            MOST POPULAR
                        </span>
                    @endif

                    <span
                        class="{{ $isFuel && ! $isFeatured ? "tag-badge-sprout" : "tag-badge" }} {{ $isFeatured ? "border-white/40 bg-white/10 text-white" : "" }}"
                    >
                        {{ $plan->tag }}
                    </span>

                    <h3
                        class="font-display mt-4 text-xl text-white uppercase"
                    >
                        {{ $plan["name"] }}
                    </h3>
                    <p class="mt-2 mb-6 text-sm {{ $isFeatured ? "text-white/80" : "text-white/60" }}">
                        {{ $plan->description }}
                    </p>

                    <div class="mb-6">
                        <span
                            class="font-display text-4xl text-white tabular-nums"
                        >
                            ${{ $plan->price}}
                        </span>
                        <span class="{{ $isFeatured ? "text-white/80" : "text-white/50" }}">/month</span>
                    </div>

                    <ul class="mb-8 flex-1 space-y-3">
                        @foreach ($plan["features"] as $feature)
                            <li
                                class="flex items-start gap-2 text-sm {{ $isFeatured ? "text-white/90" : "text-white/70" }}"
                            >
                                <svg
                                    class="w-4 h-4 mt-0.5 flex-shrink-0 {{ $isFeatured ? "text-white" : ($isFuel ? "text-sprout" : "text-brand") }}"
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
                    @auth
                        <form method="POST" action="{{ route('subscription.subscribe', $plan->stripe_price_id) }}">
                    @csrf
                            <button type="submit" class="block w-full rounded-full py-3 text-center font-bold transition-colors {{ $isFeatured ? "bg-ink text-white hover:bg-ink/80" : "border-2 border-white text-white hover:bg-white hover:text-ink" }}">Choose {{ $plan->name }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full rounded-full py-3 text-center font-bold transition-colors {{ $isFeatured ? "bg-ink text-white hover:bg-ink/80" : "border-2 border-white text-white hover:bg-white hover:text-ink" }}">Login to subscribe</a>
                    @endauth
                </div>
            @endforeach
        </div>
    </div>
</section>
