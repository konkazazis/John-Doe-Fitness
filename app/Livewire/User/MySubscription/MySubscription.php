<?php

namespace App\Livewire\User\MySubscription;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

class MySubscription extends Component
{
    public $subscription = null; 
    public $plan = null;
    public $user = null;

    public function mount()
    {
        $this->user = Auth::user();
        $this->fetchSubscription();
    }

    public function fetchSubscription()
    {

        $this->subscription = $this->user->subscriptions()->active()->first();

        if ($this->subscription) {
            $this->plan = Plan::where('stripe_price_id', $this->subscription->stripe_price)->first();
        } else {
            $this->plan = null; 
        }
    }   

    public function render()
    {
        return view('livewire.user.my-subscription.my-subscription', [
            'user' => $this->user,
        ])->layout('layouts.app', ['title' => 'My Subscription — CMS']);
    }
}   