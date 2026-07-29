<?php

namespace App\Livewire\User\AccountHistory;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountHistory extends Component
{
    public $user = null;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function fetchSubscriptions()
    {
        return $this->user->subscriptions()->orderByDesc('created_at')->get();
    }

    public function fetchInvoices()
    {
        return $this->user->invoices();
    }

    public function render()
    {
        $subscriptions = $this->fetchSubscriptions();

        $plans = Plan::whereIn('stripe_price_id', $subscriptions->pluck('stripe_price'))
            ->get()
            ->keyBy('stripe_price_id');

        return view('livewire.user.account-history.account-history', [
            'subscriptions' => $subscriptions,
            'plans' => $plans,
            'invoices' => $this->fetchInvoices(),
        ])->layout('layouts.app', ['title' => 'Account History — CMS']);
    }
}
