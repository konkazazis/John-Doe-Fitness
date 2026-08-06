<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request, string $stripe_price_id)
    {
        $plan = Plan::where('stripe_price_id', $stripe_price_id)->firstOrFail();

        return $request->user()
            ->newSubscription($plan->name, $plan->stripe_price_id)
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('home'),
            ]);
    }

    public function success(Request $request)
    {
        $user = $request->user();
        $subscription = $user->subscriptions()->latest()->first();

        if ($subscription && $subscription->asStripeSubscription()->default_payment_method) {
            $user->updateDefaultPaymentMethod(
                $subscription->asStripeSubscription()->default_payment_method
            );
        }

        return redirect()->route('user.my-subscription');
    }
}
