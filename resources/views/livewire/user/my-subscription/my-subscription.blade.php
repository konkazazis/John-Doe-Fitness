<div>
     @if (empty($subscription))
            <div class="flex flex-row min-h-screen justify-center items-center">
                <h1>No subscriptions at this time</h1>
            </div>
        @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
              {{-- Current plan --}}
        <div class="lg:col-span-2 rounded-2xl border border-zinc-200 bg-gradient-to-br from-white to-zinc-50 dark:border-zinc-800/70 dark:from-zinc-900 dark:to-zinc-900/40 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span> {{ ucfirst($subscription['stripe_status']) }}
                    </span>
                    <h2 class="mt-3 text-xl font-semibold text-zinc-800 dark:text-white">{{ $plan->name }}</h2>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $plan->description }}</p>
                </div>
                <p class="text-2xl font-semibold text-zinc-800 dark:text-white">{{ $plan->price }}€
                    <span class="text-sm font-normal text-zinc-500 dark:text-zinc-400">/{{ $plan->billing_cycle }}</span>

                </p>
            </div>

            <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-zinc-500 dark:text-zinc-400">Renews on</p>
                    <p class="mt-0.5 font-medium text-zinc-700 dark:text-zinc-200">{{ $next_billing_date?->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-zinc-500 dark:text-zinc-400">Billing cycle</p>
                    <p class="mt-0.5 font-medium text-zinc-700 dark:text-zinc-200">{{ ucfirst($plan->billing_cycle) }}</p>
                </div>
                <div>
                    <p class="text-zinc-500 dark:text-zinc-400">Payment method</p>
                    <p class="mt-0.5 font-medium text-zinc-700 dark:text-zinc-200">{{ strtoupper($user->pm_type) }}   ••••{{ $user->pm_last_four }}</p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('user.change-payment-method') }}">
                    <button type="button" class="rounded-lg border border-zinc-300 dark:border-zinc-700 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        Update payment method
                    </button>
                </a>
                <button type="button"
                    wire:click="confirmCancel"
                    class="rounded-lg px-4 py-2 text-sm font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors">
                    Cancel subscription
                </button>
            </div>
        </div>

        {{-- Usage / included --}}
        <div class="rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900/50 p-6">
            <h2 class="font-semibold text-zinc-800 dark:text-white mb-4">What's included</h2>
            <ul class="space-y-3 text-sm">
                @foreach($plan->features as $feature)
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 mt-0.5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-zinc-700 dark:text-zinc-300">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Billing history --}}
    <div class="rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800/70">
            <h2 class="font-semibold text-zinc-800 dark:text-white">Billing history</h2>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-zinc-500 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-800/70">
                    <th class="px-6 py-3 font-medium">Date</th>
                    <th class="px-6 py-3 font-medium">Description</th>
                    <th class="px-6 py-3 font-medium">Amount</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Invoice</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800/70">
                @forelse($invoices as $invoice)
                    @php $status = $invoice->asStripeInvoice()->status; @endphp
                    <tr>
                        <td class="px-6 py-4 text-zinc-700 dark:text-zinc-300">{{ $invoice->date()->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-zinc-700 dark:text-zinc-300">{{ $plan->name }}</td>
                        <td class="px-6 py-4 text-zinc-700 dark:text-zinc-300">{{ $invoice->total() }}</td>
                        <td class="px-6 py-4">
                            <span @class([
                                'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium',
                                'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' => $status === 'paid',
                                'bg-zinc-100 text-zinc-600 dark:bg-zinc-500/10 dark:text-zinc-400' => $status !== 'paid',
                            ])>
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ $invoice->asStripeInvoice()->invoice_pdf }}" target="_blank" rel="noopener noreferrer"
                                class="text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 font-medium">Download</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">No invoices yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    {{-- Cancel confirmation --}}
    <div x-data="{ show: @entangle('showCancelModal').live }"
        x-show="show"
        x-transition:enter="transition duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        @keydown.escape.window="$wire.cancelCancel()"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
        style="display: none;">
        <div @click.stop class="w-full max-w-sm rounded-2xl border border-zinc-200 bg-white dark:border-zinc-800/70 dark:bg-zinc-900 p-6 text-center shadow-xl">
            <p class="mb-2 text-lg font-bold text-zinc-800 dark:text-white">Cancel subscription?</p>
            <p class="mb-6 text-sm text-zinc-500 dark:text-zinc-400">This will cancel your subscription immediately. This cannot be undone.</p>
            <div class="flex justify-center gap-3">
                <button wire:click="cancelCancel" class="px-4 py-2 text-sm font-semibold text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white">Keep subscription</button>
                <button wire:click="cancel" class="rounded-lg bg-rose-600 px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-rose-700">Cancel subscription</button>
            </div>
        </div>
    </div>
</div>
