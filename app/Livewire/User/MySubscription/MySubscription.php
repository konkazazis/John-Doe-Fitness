<?php

namespace App\Livewire\User\MySubscription;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

class MySubscription extends Component
{
    public $subscription = null; 
    public $plan = null;

    public function mount()
    {
        $this->fetchSubscription();
    }

    public function fetchSubscription()
    {
        $user = Auth::user();

        $this->subscription = $user->subscription('default');
        $this->plan = Plan::where('stripe_price_id', $this->subscription->stripe_price)->first();

    }

    public function render()
    {
        return view('livewire.user.my-subscription.my-subscription')
            ->layout('layouts.app', ['title' => 'My Subscription — CMS']);
    }
}   