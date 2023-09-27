<?php

namespace Src\BlendedConcept\Finance\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class B2bSubscription extends Entity
{
    public function __construct(
        public readonly ?int $subscription_id,
        public readonly ?int $organisation_id,
        public readonly ?string $receipt_image,
        public readonly ?float $storage_limit,
        public readonly ?int $num_teacher_license,
        public readonly ?int $num_student_license,
    ) {
    }

    public function toArray(): array
    {
        return [
            'subscription_id' => $this->subscription_id,
            'organisation_id' => $this->organisation_id,
            'receipt_image' => $this->receipt_image,
            'storage_limit' => $this->storage_limit,
            'num_teacher_license' => $this->num_teacher_license,
            'num_student_license' => $this->num_student_license,
        ];
    }
}
