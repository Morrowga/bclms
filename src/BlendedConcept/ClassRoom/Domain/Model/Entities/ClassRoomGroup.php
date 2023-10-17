<?php

namespace Src\BlendedConcept\ClassRoom\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class ClassRoomGroup extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $classroom_id,
        public readonly string $name,
        public readonly ?array $students
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'classroom_id' => $this->classroom_id,
            'name' => $this->name,
            'students' => $this->students,
        ];
    }
}
