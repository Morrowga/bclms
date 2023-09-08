<?php

namespace Src\BlendedConcept\ClassRoom\Application\DTO;

use Illuminate\Http\Request;

class ClassRoomData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $organization_id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $classroom_photo,

    ) {
    }

    public static function fromRequest(Request $request, $classroom_id): ClassRoomData
    {
        return new self(
            id: $classroom_id,
            organization_id: $request->organization_id,
            name: $request->name,
            description: $request->description,
            classroom_photo: $request->classroom_photo,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'organization_id' => auth()->user()->organization_id,
            'name' => $this->name,
            'description' => $this->description,
            'classroom_photo' => $this->classroom_photo,
        ];
    }
}
