<div class="space-y-6">
    {{-- Subscription history --}}
    <div class="rounded-2xl border border-zinc-800/70 bg-zinc-900/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-zinc-800/70">
            <h2 class="font-semibold text-white">Subscriptions</h2>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-zinc-500 border-b border-zinc-800/70">
                    <th class="px-6 py-3 font-medium">Plan</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium">Started</th>
                    <th class="px-6 py-3 font-medium">Ended</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800/70">
                @forelse($subscriptions as $subscription)
                    @php $plan = $plans->get($subscription->stripe_price); @endphp
                    <tr>
                        <td class="px-6 py-4 text-zinc-300">{{ $plan->name ?? $subscription->stripe_price }}</td>
                        <td class="px-6 py-4">
                            <span @class([
                                'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium',
                                'bg-emerald-500/10 text-emerald-400' => $subscription->stripe_status === 'active',
                                'bg-zinc-500/10 text-zinc-400' => $subscription->stripe_status !== 'active',
                            ])>
                                {{ ucfirst($subscription->stripe_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-zinc-300">{{ $subscription->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-zinc-300">{{ $subscription->ends_at?->format('M d, Y') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-zinc-500">No subscriptions yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Payment history --}}
    <div class="rounded-2xl border border-zinc-800/70 bg-zinc-900/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-zinc-800/70">
            <h2 class="font-semibold text-white">Payments</h2>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-zinc-500 border-b border-zinc-800/70">
                    <th class="px-6 py-3 font-medium">Date</th>
                    <th class="px-6 py-3 font-medium">Description</th>
                    <th class="px-6 py-3 font-medium">Amount</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Invoice</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800/70">
                @forelse($invoices as $invoice)
                    @php
                        $stripeInvoice = $invoice->asStripeInvoice();
                        $status = $stripeInvoice->status;
                        $description = $stripeInvoice->lines->data[0]->description ?? '—';
                    @endphp
                    <tr>
                        <td class="px-6 py-4 text-zinc-300">{{ $invoice->date()->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-zinc-300">{{ $description }}</td>
                        <td class="px-6 py-4 text-zinc-300">{{ $invoice->total() }}</td>
                        <td class="px-6 py-4">
                            <span @class([
                                'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium',
                                'bg-emerald-500/10 text-emerald-400' => $status === 'paid',
                                'bg-zinc-500/10 text-zinc-400' => $status !== 'paid',
                            ])>
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ $stripeInvoice->invoice_pdf }}" target="_blank" rel="noopener noreferrer"
                                class="text-zinc-400 hover:text-zinc-200 font-medium">Download</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-zinc-500">No payments yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
