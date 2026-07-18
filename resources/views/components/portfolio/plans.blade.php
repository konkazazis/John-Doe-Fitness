<section id="pricing" class="bg-stone-50 py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-14 flex flex-col items-center text-center">
            <span class="section-label">Coaching plans</span>
            <h2 class="section-heading">Pick your plan</h2>
            <p class="max-w-xl text-lg text-stone-600">
                Every plan includes both training and nutrition coaching.
            </p>
        </div>

        <div class="grid items-stretch gap-6 md:grid-cols-3">
            @foreach ($plans as $plan)
                @php
                    $isFuel = $plan['group'] === 'fuel';
                @endphp

                <div
                    class="panel-card flex flex-col {{ $plan["featured"] ?? false ? "ring-2 ring-[#eb5424] relative" : "" }}"
                >
                    @if ($plan["featured"] ?? false)
                        <span class="category-badge absolute -top-3 left-8">
                            Most popular
                        </span>
                    @endif

                    <span
                        class="{{ $isFuel ? "tag-badge-sprout" : "tag-badge" }}"
                    >
                        {{ $plan->tag }}
                    </span>

                    <h3
                        class="font-display mt-4 text-2xl font-bold text-stone-900"
                    >
                        {{ $plan["name"] }}
                    </h3>
                    <p class="mt-2 mb-6 text-stone-600">
                        {{ $plan->description }}
                    </p>

                    <div class="mb-6">
                        <span
                            class="font-display text-4xl font-bold text-stone-900 tabular-nums"
                        >
                            ${{ $plan->price}}
                        </span>
                        <span class="text-stone-500">/month</span>
                    </div>

                    <ul class="mb-8 flex-1 space-y-3">
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
                    @auth
                        <form method="POST" action="{{ route('subscription.subscribe', $plan->key) }}">
                    @csrf
                            <button type="submit" class="btn btn-primary">Choose {{ $plan->name }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login to subscribe</a>
                    @endauth
                </div>
            @endforeach
        </div>
    </div>
</section>
