<?php

namespace Src\BlendedConcept\ClassRoom\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class ClassRoom extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $organisation_id,
        public readonly string $name,
        public readonly string $description,
        public readonly ?string $classroom_photo,
        public readonly ?array $teachers,
        public readonly ?array $students
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'organisation_id' => $this->organisation_id,
            'name' => $this->name,
            'description' => $this->description,
            'classroom_photo' => $this->classroom_photo,
            'teachers' => $this->teachers,
            'students' => $this->students,
        ];
    }
}
