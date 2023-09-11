<?php

namespace Src\BlendedConcept\Finance\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Subscription extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $start_date,
        public readonly string $end_date,
        public readonly string $payment_date,
        public readonly string $payment_status,
        public readonly ?string $stripe_status,
        public readonly ?string $stripe_price,
    ) {
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

        ];
    }
}
