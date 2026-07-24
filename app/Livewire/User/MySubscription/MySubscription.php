<?php

namespace App\Livewire\User\MySubscription;

use Livewire\Component;

class MySubscription extends Component
{
    public function render()
    {
        return view('livewire.user.my-subscription.my-subscription')->layout('layouts.app', ['title' => 'My Subscription — CMS']);
    }
}