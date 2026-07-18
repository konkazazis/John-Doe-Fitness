<?php
namespace App\Livewire;

use Livewire\Component;

class SubscriptionPlans extends Component
{
    public $plans;

    public function mount()
    {
        $this->plans = config('plans');
    }

    public function subscribe($planKey)
    {
        $priceId = config("plans.$planKey.price_id");

        // Redirect to Stripe Checkout (recommended over inline card forms)
        return redirect(
            auth()->user()
                ->newSubscription('default', $priceId)
                ->checkout([
                    'success_url' => route('subscription.success'),
                    'cancel_url' => route('subscription.plans'),
                ])
        );
    }

    public function render()
    {
        return view('livewire.subscription-plans');
    }
}