<?php

namespace App\Livewire\User\MySubscription;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MySubscription extends Component
{
    public $subscription = null;

    public $plan = null;

    public $user = null;

    public $next_billing_date = null;

    public bool $showCancelModal = false;

    public function mount()
    {
        $this->user = Auth::user();

        $this->subscription = $this->user->subscriptions()->active()->first();

        if ($this->subscription) {
            $this->fetchSubscription();
        } else {
            $this->plan = null;
        }
    }

    public function fetchInvoices()
    {
        return $this->subscription ? $this->subscription->invoices() : collect();
    }

    public function fetchSubscription()
    {
        $this->plan = Plan::where('stripe_price_id', $this->subscription->stripe_price)->first();
        $this->next_billing_date = $this->subscription->currentPeriodEnd();
    }

    public function changePaymentMethod(Request $request)
    {

        return $request->user()->redirectToBillingPortal(route('user.payment-method-updated'));
    }

    public function paymentMethodUpdated(Request $request)
    {
        $request->user()->updateDefaultPaymentMethodFromStripe();

        return redirect()->route('user.my-subscription');
    }

    public function confirmCancel(): void
    {
        $this->showCancelModal = true;
    }

    public function cancelCancel(): void
    {
        $this->showCancelModal = false;
    }

    public function cancel()
    {
        if ($this->subscription) {
            $this->subscription->cancelNow();
        }

        $this->showCancelModal = false;

        return redirect()->route('user.my-subscription');

    }

    public function render()
    {
        return view('livewire.user.my-subscription.my-subscription', [
            'user' => $this->user,
            'next_billing_date' => $this->next_billing_date,
            'invoices' => $this->fetchInvoices(),
        ])->layout('layouts.app', ['title' => 'My Subscription']);
    }
}
