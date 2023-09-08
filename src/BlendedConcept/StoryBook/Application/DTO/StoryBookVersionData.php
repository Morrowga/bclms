<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookVersionData;

class StoryBookVersionData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $storybook_id,
        public readonly ?int $teacher_id,
        public readonly string $name,
        public readonly string $description,
    ) {
    }

    public static function fromRequest(Request $request, $storybook_version_id): StoryBookVersionData
    {
        return new self(
            id : $storybook_version_id,
            storybook_id : $this->storybook_id,
            teacher_id : $this->teacher_id,
            name : $this->name,
            description : $this->description,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'storybook_id' => $this->storybook_id,
            'teacher_id' => $this->teacher_id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
