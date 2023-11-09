<?php

namespace Src\BlendedConcept\Organisation\Application\DTO;

use Illuminate\Http\Request;

class StudentData
{
    public function __construct(
        public readonly ?int $student_id,
        public readonly int $user_id,
        public readonly ?int $device_id,
        public readonly ?int $parent_id,
        public readonly ?int $organisation_id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $contact_number,
        public readonly string $email,
        public readonly string $gender,
        public readonly string $dob,
        public readonly string $education_level,
        public readonly ?int $num_gold_coins,
        public readonly ?int $num_silver_coins,
        public readonly ?string $student_code,
        public readonly ?string $parent_first_name,
        public readonly ?string $parent_last_name,
        public readonly ?float $total_time_spent,
        public readonly ?array $disability_types,
        public readonly ?array $learning_needs,
        public readonly ?string $login_username
    ) {
    }

    public static function fromRequest(Request $request, $student): StudentData
    {
        return new self(
            student_id: $request->student_id,
            user_id: $student->user->id,
            device_id: $request->device_id,
            organisation_id: $request->organisation_id,
            parent_id: $request->parent_id,
            first_name: $request->first_name,
            last_name: $request->last_name,
            contact_number: $request->contact_number,
            email: $request->email,
            gender: $request->gender,
            dob: $request->dob,
            education_level: $request->education_level,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            student_code: $request->student_code,
            parent_first_name: $request->parent_first_name,
            parent_last_name: $request->parent_last_name,
            total_time_spent: $request->total_time_spent,
            disability_types: $request->disability_types,
            learning_needs: $request->learning_needs,
            login_username: $request->login_username
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'education_level' => $this->education_level,
            'num_gold_coins' => $this->num_gold_coins,
            'num_silver_coins' => $this->num_silver_coins,
            'student_code' => $this->student_code,
            'total_time_spent' => $this->total_time_spent,
            'disability_types' => $this->disability_types,
            'learning_needs' => $this->learning_needs,
            'parent_first_name' => $this->parent_first_name,
            'parent_last_name' => $this->parent_last_name,
            'login_username' => $this->login_username
        ];
    }
}
