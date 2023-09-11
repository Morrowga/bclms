<?php

namespace Src\BlendedConcept\Student\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Student extends AggregateRoot implements \JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $playlist_photo,
        public readonly ?int $student_id,
        public readonly ?int $teacher_id

    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'playlist_photo' => $this->playlist_photo,
            'student_id' => $this->student_id,
            'teacher_id' => $this->teacher_id,
        ];
    }
}
