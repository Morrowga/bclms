<?php

namespace Src\BlendedConcept\Student\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Student\Application\DTO\PlaylistData;

class PlaylistData
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $student_id,
        public readonly ?int $teacher_id,
        public readonly ?string $name,
    ) {
    }

    public static function fromRequest(Request $request, $playlist_id = null): PlaylistData
    {

        return new self(
            id: $playlist_id,
            student_id: $request->student_id,
            teacher_id: $request->teacher_id,
            name: $request->name,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'teacher_id' => $this->teacher_id,
            'name' => $this->name,
        ];
    }
}