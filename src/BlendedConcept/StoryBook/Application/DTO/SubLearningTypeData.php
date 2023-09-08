<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\DTO\SubLearningTypeData;

class SubLearningTypeData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $learning_needs_id,
        public readonly string $name,
    ) {
    }

    public static function fromRequest(Request $request, $sub_learning_type_id): SubLearningTypeData
    {
        return new self(
            id : $sub_learning_type_id,
            learning_needs_id : $this->learning_needs_id,
            name : $this->name,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'learning_needs_id' => $this->learning_needs_id,
            'name' => $this->name,
        ];
    }
}
