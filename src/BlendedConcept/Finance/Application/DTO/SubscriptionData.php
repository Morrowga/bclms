<?php

namespace Src\BlendedConcept\FInance\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;

class SubscriptionData
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $start_date,
        public readonly ?string $end_date,
        public readonly ?string $payment_date,
        public readonly ?string $payment_status,
        public readonly ?string $stripe_status,
        public readonly ?string $stripe_price,
        public readonly ?array $b2b_subscription,
        public readonly ?int $plan_id,
        public readonly ?int $user_id
    ) {
    }

    public static function fromRequest(Request $request, $subscription): SubscriptionData
    {
        return new self(
            id: $subscription->id,
            start_date: $request->start_date,
            end_date: $request->end_date,
            payment_date: $request->payment_date,
            payment_status: $request->payment_status,
            stripe_status: $request->stripe_status,
            stripe_price: $request->stripe_price,
            b2b_subscription: $request->b2b_subscription,
            plan_id: $request->plan_id,
            user_id: $request->user_id
        );
    }

    public static function fromEloquent(SubscriptionEloquentModel $subscription): self
    {
        return new self(
            id: $subscription->id,
            start_date: $subscription->start_date,
            end_date: $subscription->end_date,
            payment_date: $subscription->payment_date,
            payment_status: $subscription->payment_status,
            stripe_status: $subscription->stripe_status,
            stripe_price: $subscription->stripe_price,
            b2b_subscription: $subscription->b2b_subscription,
            plan_id: $subscription->b2b_subscription->plan->id,
            user_id: $subscription->b2b_subscription->user->id
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'payment_date' => $this->payment_date,
            'payment_status' => $this->payment_status,
            'stripe_status' => $this->stripe_status,
            'stripe_price' => $this->stripe_price,
            'b2b_subscription' => $this->b2b_subscription,
            'plan_id' => $this->plan_id,
            'user_id' => $this->user_id,
        ];
    }
}
