<?php

namespace Src\BlendedConcept\Finance\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Plan extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $stripe_id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?float $price,
        public readonly ?string $payment_period,
        public readonly ?string $allocated_storage,
        public readonly ?string $teacher_license,
        public readonly ?string $student_license,
        public readonly ?bool $is_hidden,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'stripe_id' => $this->stripe_id,
            'name' => 'Default Plan',
            'description' => $this->description,
            'price' => $this->price,
            'payment_period' => $this->payment_period,
            'allocated_storage' => $this->allocated_storage,
            'teacher_license' => $this->teacher_license,
            'student_license' => $this->student_license,
            'is_hidden' => $this->is_hidden,

        ];
    }
}
