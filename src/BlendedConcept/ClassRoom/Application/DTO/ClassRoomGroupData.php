<?php

namespace Src\BlendedConcept\ClassRoom\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\ClassRoom\Application\DTO\ClassRoomGroupData;

class ClassRoomGroupData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $classroom_id,
        public readonly string $name,

    ) {
    }

    public static function fromRequest(Request $request, $classroom_id): ClassRoomGroupData
    {
        return new self(
            id: $classroom_id,
            classroom_id: $request->classroom_id,
            name: $request->name,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'classroom_id' => $this->classroom_id,
            'name' => $this->name,
        ];
    }
}
