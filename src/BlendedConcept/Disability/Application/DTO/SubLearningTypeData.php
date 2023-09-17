<?php

namespace Src\BlendedConcept\Disability\Application\DTO;

use Illuminate\Http\Request;

class SubLearningTypeData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $learning_needs_id,
        public readonly string $name,
    ) {
    }

    public static function fromRequest(Request $request, $sub_learning_type): SubLearningTypeData
    {
        return new self(
            id: $sub_learning_type->id,
            learning_needs_id: $request->learning_needs_id,
            name: $request->name,
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
