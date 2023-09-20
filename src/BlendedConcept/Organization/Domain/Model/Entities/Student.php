<?php

namespace Src\BlendedConcept\Organization\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Student extends Entity
{
    public function __construct(
        public readonly ?int $student_id,
        public readonly int $user_id,
        public readonly ?int $device_id,
        public readonly string $gender,
        public readonly string $dob,
        public readonly string $education_level,
        public readonly ?int $num_gold_coins,
        public readonly ?int $num_silver_coins,
        public readonly string $student_code,
        public readonly ?float $total_time_spent,
        public readonly ?array $disability_types,
        public readonly ?array $learning_needs,
    ) {
    }

    public function toArray(): array
    {
        return [
            'student_id' => $this->student_id,
            'user_id' => $this->user_id,
            'device_id' => $this->device_id,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'education_level' => $this->education_level,
            'num_gold_coins' => $this->num_gold_coins,
            'num_silver_coins' => $this->num_silver_coins,
            'student_code' => $this->student_code,
            'total_time_spent' => $this->total_time_spent,
            'disability_types' => $this->disability_types,
            'learning_needs' => $this->learning_needs,
        ];
    }
}
