<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;

class TagData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
    ) {
    }

    public static function fromRequest(Request $request, $tag_id): TagData
    {
        return new self(
            id : $tag_id,
            name : $name,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
