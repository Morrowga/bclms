<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;

class StoryBookVersionData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $storybook_id,
        public readonly ?int $teacher_id,
        public readonly string $name,
        public readonly string $description,
        public readonly ?int $h5p_id,
        public readonly ?string $param
    ) {
    }

    public static function fromRequest(Request $request, $storybook_version_id): StoryBookVersionData
    {
        return new self(
            id: $storybook_version_id,
            storybook_id: $request->storybook_id,
            teacher_id: $request->teacher_id,
            name: $request->name,
            description: $request->description,
            h5p_id: $request->h5p_id,
            param: $request->param
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
            'h5p_id' => $this->h5p_id,
            'param' => $this->param
        ];
    }
}
