<?php

namespace Src\BlendedConcept\ClassRoom\Application\DTO;

use Illuminate\Http\Request;

class ClassRoomData
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

    public static function fromRequest(Request $request, $classroom_id): ClassRoomData
    {
        return new self(
            id: $classroom_id,
            organization_id: $request->organization_id,
            name: $request->name,
            teacher_id: $request->teacher_id,
            venue: $request->venue,
            students : $request->students
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'organization_id' => auth()->user()->organization_id,
            'teacher_id' => $this->teacher_id,
            'name' => $this->name,
            'venue' => $this->venue,
            'students' => $this->students,
        ];
    }
}
