<?php

namespace Src\BlendedConcept\Student\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Student extends AggregateRoot implements \JsonSerializable
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
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
