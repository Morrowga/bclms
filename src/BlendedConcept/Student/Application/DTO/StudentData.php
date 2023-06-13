<?php

namespace Src\BlendedConcept\Student\Application\DTO;

use Illuminate\Http\Request;

class StudentData
{

    public function __construct(
        public readonly ?int $id,
        public readonly ?int $organization_id,
        public readonly ?int $device_id,
        public readonly ?string $student_code,
        public readonly ?string $name,
        public readonly ?string $nickname,
        public readonly ?string $description,
        public readonly ?string $dob,
        public readonly ?string $grade,
        public readonly ?string $star_earn,
        public readonly ?string $coin_earn,
    ) {
    }

    public static function fromRequest(Request $request, $student_id = null): StudentData
    {

        return new self(
            id: $student_id,
            organization_id: $request->organization_id,
            device_id: $request->device_id,
            student_code: $request->student_code,
            name: $request->name,
            nickname: $request->nickname,
            description: $request->description,
            dob: $request->dob,
            grade: $request->grade,
            star_earn: $request->star_earn,
            coin_earn: $request->coin_earn,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'organization_id' => auth()->user()->organization_id ,
            'device_id' => $this->device_id,
            'student_code' => $this->student_code,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'description' => $this->description,
            'dob' => $this->dob,
            'grade' => $this->grade,
            'star_earn' => $this->star_earn,
            'coin_earn' => $this->coin_earn,
        ];
    }
}
