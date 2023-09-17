<?php

namespace Src\BlendedConcept\Disability\Application\DTO;

use Illuminate\Http\Request;

class LearningNeedData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $description,
    ) {
    }

    public static function fromRequest(Request $request, $learning_need): LearningNeedData
    {
        return new self(
            id: $learning_need->id,
            name: $request->name,
            description: $request->description,
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
