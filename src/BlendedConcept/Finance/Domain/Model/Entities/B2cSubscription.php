<?php

namespace Src\BlendedConcept\Finance\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class B2Subscription extends Entity
{
    public function __construct(
        public readonly ?int $subscription_id,
        public readonly ?int $user_id,
        public readonly ?int $plan_id,
    ) {
    }

    public function toArray(): array
    {
        return [
            'subscription_id' => $this->subscription_id,
            'user_id' => $this->user_id,
            'plan_id' => $this->plan_id,
        ];
    }
}
