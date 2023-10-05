<?php

namespace Src\BlendedConcept\Student\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Student extends AggregateRoot implements \JsonSerializable
{
    public function __construct(
        public readonly ?string $first_name,
        public readonly ?string $last_name,
        public readonly int $student_id,
        public readonly int $user_id,
        public readonly int $device_id,
        public readonly string $gender,
        public readonly string $dob,
        public readonly string $education_level,
        public readonly int $num_gold_coins,
        public readonly int $num_silver_coins,
        public readonly int $student_code,
        public readonly ?int $contact_number,
        public readonly float $total_time_spent,
        public readonly ?string $parent_first_name,
        public readonly ?string $parent_last_name,
        public readonly ?string $email
    ) {
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'student_id' => $this->student_id,
            'user_id' => $this->user_id,
            'device_id' => $this->device_id,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'education_level' => $this->education_level,
            'num_gold_coins' => $this->num_gold_coins,
            'num_silver_coins' => $this->num_silver_coins,
            'student_code' => $this->student_code,
            'contact_number' => $this->contact_number,
            'total_time_spent' => $this->total_time_spent,
            'parent_first_name' => $this->parent_first_name,
            'parent_last_name' => $this->parent_last_name,
            'email' => $this->email
        ];
    }
}
