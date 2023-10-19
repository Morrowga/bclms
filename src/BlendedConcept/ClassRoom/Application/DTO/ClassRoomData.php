<?php

namespace Src\BlendedConcept\ClassRoom\Application\DTO;

use Illuminate\Http\Request;

class ClassRoomData
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $organisation_id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $classroom_photo,
        public readonly ?array $teachers,
        public readonly ?array $students

    ) {
    }

    public static function fromRequest(Request $request, $classroom_id): ClassRoomData
    {
        return new self(
            id: $classroom_id,
            organisation_id: $request->organisation_id,
            name: $request->name,
            description: $request->description,
            classroom_photo: $request->classroom_photo,
            teachers: $request->teachers,
            students: $request->students
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'organisation_id' => auth()->user()->organisation_id,
            'name' => $this->name,
            'description' => $this->description,
            'classroom_photo' => $this->classroom_photo,
            'teachers' => $this->teachers,
            'students' => $this->students,
        ];
    }
}
