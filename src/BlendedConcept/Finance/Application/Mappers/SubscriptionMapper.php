<?php

namespace Src\BlendedConcept\Finance\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;

class SubscriptionMapper
{
    public static function fromRequest(Request $request, $subscription_id = null): Subscription
    {
        return new Subscription(
            id: $subscription_id,
            start_date: $request->start_date,
            end_date: $request->end_date,
            payment_date: $request->payment_date,
            payment_status: $request->payment_status,
            stripe_status: $request->stripe_status,
            stripe_price: $request->stripe_price
        );
    }

    public static function fromArray(array $subscription): Subscription
    {
        $subscriptionEloquent = new SubscriptionEloquentModel($subscription);
        $subscriptionEloquent->id = $subscription['id'] ?? null;

        return self::fromEloquent($subscriptionEloquent);
    }

    public static function fromEloquent(SubscriptionEloquentModel $subscription): Subscription
    {
        return new Subscription(
            id: $subscription->id,
            start_date: $subscription->start_date,
            end_date: $subscription->end_date,
            payment_date: $subscription->payment_date,
            payment_status: $subscription->payment_status,
            stripe_status: $subscription->stripe_status,
            stripe_price: $subscription->stripe_price
        );
    }

    public static function toEloquent(Subscription $subscription): SubscriptionEloquentModel
    {
        $subscriptionEloquent = new SubscriptionEloquentModel();

        if ($subscription->id) {
            $subscriptionEloquent = SubscriptionEloquentModel::query()->findOrFail($subscription->id);
        }
        $subscriptionEloquent->start_date = $subscription->start_date;
        $subscriptionEloquent->end_date = $subscription->end_date;
        $subscriptionEloquent->payment_date = $subscription->payment_date;
        $subscriptionEloquent->payment_status = $subscription->payment_status;
        $subscriptionEloquent->stripe_status = $subscription->stripe_status;
        $subscriptionEloquent->stripe_price = $subscription->stripe_price;
        return $subscriptionEloquent;
    }
}
