<?php

namespace Src\BlendedConcept\Finance\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Plan extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly float $storage_limit,
        public readonly int $num_student_license,
        public readonly bool $allow_customisation,
        public readonly bool $allow_personalisation,
        public readonly string $status,
        public readonly float $price,
        public readonly string $payment_period,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'storage_limit' => $this->storage_limit,
            'num_student_license' => $this->num_student_license,
            'allow_customisation' => $this->allow_customisation,
            'allow_personalisation' => $this->allow_personalisation,
            'status' => $this->status,
            'price' => $this->price,
            'payment_period' => $this->payment_period,
        ];
    }
}
