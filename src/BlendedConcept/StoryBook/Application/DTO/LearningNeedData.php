<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;

class LearningNeedData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $description,
    ) {
    }

    public static function fromRequest(Request $request, $learning_need_id): LearningNeedData
    {
        return new self(
            id : $learning_need_id,
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
