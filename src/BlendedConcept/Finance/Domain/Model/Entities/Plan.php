<?php

namespace Src\BlendedConcept\Finance\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Plan extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $storage_limit,
        public readonly int $num_student_profiles,
        public readonly bool $allow_customisation,
        public readonly bool $allow_personalisation,
        public readonly bool $full_library_access,
        public readonly bool $concurrent_access,
        public readonly bool $weekly_learning_report,
        public readonly bool $dedicated_student_report,
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
            'description' => $this->description,
            'storage_limit' => $this->storage_limit,
            'num_student_profiles' => $this->num_student_profiles,
            'allow_customisation' => $this->allow_customisation,
            'allow_personalisation' => $this->allow_personalisation,
            'full_library_access' => $this->full_library_access,
            'concurrent_access' => $this->concurrent_access,
            'weekly_learning_report' => $this->weekly_learning_report,
            'dedicated_student_report' => $this->dedicated_student_report,
            'status' => $this->status,
            'price' => $this->price,
            'payment_period' => $this->payment_period,
        ];
    }
}
