<div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- Current plan --}}
        <div class="lg:col-span-2 rounded-2xl border border-zinc-800/70 bg-gradient-to-br from-zinc-900 to-zinc-900/40 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                    </span>
                    <h2 class="mt-3 text-xl font-semibold text-white">Pro Coaching Plan</h2>
                    <p class="mt-1 text-sm text-zinc-500">Full nutrition + exercise programming with weekly check-ins.</p>
                </div>
                <p class="text-2xl font-semibold text-white">$49<span class="text-sm font-normal text-zinc-500">/mo</span></p>
            </div>

            <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-zinc-500">Renews on</p>
                    <p class="mt-0.5 font-medium text-zinc-200">Aug 18, 2026</p>
                </div>
                <div>
                    <p class="text-zinc-500">Billing cycle</p>
                    <p class="mt-0.5 font-medium text-zinc-200">Monthly</p>
                </div>
                <div>
                    <p class="text-zinc-500">Payment method</p>
                    <p class="mt-0.5 font-medium text-zinc-200">Visa •••• 4471</p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="button" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-medium text-zinc-950 hover:bg-emerald-400 transition-colors">
                    Upgrade plan
                </button>
                <button type="button" class="rounded-lg border border-zinc-700 px-4 py-2 text-sm font-medium text-zinc-300 hover:bg-zinc-800 transition-colors">
                    Update payment method
                </button>
                <button type="button" class="rounded-lg px-4 py-2 text-sm font-medium text-rose-400 hover:bg-rose-500/10 transition-colors">
                    Cancel subscription
                </button>
            </div>
        </div>

        {{-- Usage / included --}}
        <div class="rounded-2xl border border-zinc-800/70 bg-zinc-900/50 p-6">
            <h2 class="font-semibold text-white mb-4">What's included</h2>
            <ul class="space-y-3 text-sm">
                @foreach([
                    'Personalized nutrition plan',
                    'Weekly workout programming',
                    'Direct coach messaging',
                    'Progress & body metrics tracking',
                ] as $feature)
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 mt-0.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-zinc-300">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Billing history --}}
    <div class="rounded-2xl border border-zinc-800/70 bg-zinc-900/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-zinc-800/70">
            <h2 class="font-semibold text-white">Billing history</h2>
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
                @foreach([
                    ['date' => 'Jul 18, 2026', 'desc' => 'Pro Coaching Plan', 'amount' => '$49.00', 'status' => 'Paid'],
                    ['date' => 'Jun 18, 2026', 'desc' => 'Pro Coaching Plan', 'amount' => '$49.00', 'status' => 'Paid'],
                    ['date' => 'May 18, 2026', 'desc' => 'Pro Coaching Plan', 'amount' => '$49.00', 'status' => 'Paid'],
                ] as $invoice)
                    <tr>
                        <td class="px-6 py-4 text-zinc-300">{{ $invoice['date'] }}</td>
                        <td class="px-6 py-4 text-zinc-300">{{ $invoice['desc'] }}</td>
                        <td class="px-6 py-4 text-zinc-300">{{ $invoice['amount'] }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-400">
                                {{ $invoice['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="text-zinc-400 hover:text-zinc-200 font-medium">Download</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>