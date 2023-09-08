<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\DTO\ThemeData;

class ThemeData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
    ) {
    }


    public static function fromRequest(Request $request, $theme_id): ThemeData
    {
        return new self(
            id : $theme_id,
            name : $this->name,
            description : $this->description,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
