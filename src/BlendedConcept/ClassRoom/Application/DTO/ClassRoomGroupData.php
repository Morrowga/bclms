<?php

namespace Src\BlendedConcept\ClassRoom\Application\DTO;

use Illuminate\Http\Request;

class ClassRoomGroupData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $classroom_id,
        public readonly string $name,
        public readonly ?array $students

    ) {
    }

    public static function fromRequest(Request $request, $classroom_id): ClassRoomGroupData
    {
        return new self(
            id: $classroom_id,
            classroom_id: $request->classroom_id,
            name: $request->name,
            students: $request->students
        );
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
