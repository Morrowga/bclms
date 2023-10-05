<?php

namespace Src\BlendedConcept\Student\Application\DTO;

use Illuminate\Http\Request;

class StudentData
{
    public function __construct(
        public readonly ?int $student_id,
        public readonly ?string $first_name,
        public readonly ?string $last_name,
        public readonly ?int $user_id,
        public readonly ?int $device_id,
        public readonly ?int $parent_id,
        public readonly ?int $organisation_id,
        public readonly ?string $gender,
        public readonly ?string $dob,
        public readonly ?string $education_level,
        public readonly ?string $num_gold_coins,
        public readonly ?string $num_silver_coins,
        public readonly ?string $student_code,
        public readonly ?int $contact_number,
        public readonly ?string $total_time_spent,
        public readonly ?string $parent_first_name,
        public readonly ?string $parent_last_name,
        public readonly ?string $email,
        public readonly ?array $learning_needs,
        public readonly ?array $disability_types
    ) {
    }

    public static function fromRequest(Request $request, $student_id = null): StudentData
    {

        return new self(
            first_name: $request->first_name,
            last_name: $request->last_name,
            student_id: $student_id,
            user_id: $request->user_id,
            device_id: $request->device_id,
            organisation_id: $request->organisation_id,
            parent_id: $request->parent_id,
            gender: $request->gender,
            dob: $request->dob,
            education_level: $request->education_level,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            student_code: $request->student_code,
            total_time_spent: $request->total_time_spent,
            parent_first_name: $request->parent_first_name,
            parent_last_name: $request->parent_last_name,
            email: $request->email,
            contact_number: $request->contact_number,
            learning_needs: $request->learning_needs,
            disability_types: $request->disability_types
        );
    }

    public function toArray(): array
    {
        return [
            'student_id' => $this->student_id,
            'user_id' => $this->user_id,
            'device_id' => $this->device_id,
            'organisation_id' => $this->organisation_id,
            'parent_id' => $this->parent_id,
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
            'email' => $this->email,
            'learning_needs' => $this->learning_needs,
            'disability_types' => $this->disability_types
        ];
    }
}
