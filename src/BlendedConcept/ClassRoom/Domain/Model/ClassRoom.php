<?php

namespace Src\BlendedConcept\ClassRoom\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class ClassRoom extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $organization_id,
        public readonly ?int $teacher_id,
        public readonly ?string $name,
        public readonly ?string $venue,
        public readonly ?array $students,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'teacher_id' => $this->teacher_id,
            'name' => $this->name,
            'venue' => $this->venue,
            'students' => $this->students,
        ];
    }
}
