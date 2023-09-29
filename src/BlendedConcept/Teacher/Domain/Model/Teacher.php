<?php

namespace Src\BlendedConcept\Teacher\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Teacher extends AggregateRoot
{
    public function __construct(
        public readonly ?int $teacher_id,
        public readonly int $user_id,
        public readonly ?int $organisation_id,
        public readonly ?float $allocated_storage_limit,
        public readonly ?int $curr_subscription_id
    ) {
    }

    public function toArray(): array
    {
        return [
            "teacher_id" => $this->teacher_id,
            "user_id"  => $this->user_id,
            "organisation_id" => $this->organisation_id,
            "allocated_storage_limit" => $this->allocated_storage_limit,
            "curr_subscription_id" => $this->curr_subscription_id
        ];
    }
}
