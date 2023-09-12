<?php

namespace Src\BlendedConcept\Student\Application\DTO;

use Illuminate\Http\Request;

class StudentData
{
    public function __construct(
        public readonly ?int $student_id,
        public readonly ?int $user_id,
        public readonly ?int $device_id,
        public readonly ?string $gender,
        public readonly ?string $dob,
        public readonly ?string $education_level,
        public readonly ?string $num_gold_coins,
        public readonly ?string $num_silver_coins,
        public readonly ?string $student_code,
        public readonly ?string $total_time_spent,
    ) {
    }

    public static function fromRequest(Request $request, $student_id = null): StudentData
    {

        return new self(
            student_id: $student_id,
            user_id: $request->user_id,
            device_id: $request->device_id,
            gender: $request->gender,
            dob: $request->dob,
            education_level: $request->education_level,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            student_code: $request->student_code,
            total_time_spent: $request->total_time_spent,
        );
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
        ];
    }
}
