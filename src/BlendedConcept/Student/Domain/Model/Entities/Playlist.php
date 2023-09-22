<?php

namespace Src\BlendedConcept\Student\Domain\Model\Entities;

use Src\Common\Domain\Entity;


class Playlist extends Entity implements \JsonSerializable
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?int $student_id,
        public readonly ?int $teacher_id

    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'student_id' => $this->student_id,
            'teacher_id' => auth()->user()->id,
        ];
    }
}
