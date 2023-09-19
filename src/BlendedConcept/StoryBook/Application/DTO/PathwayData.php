<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;

class PathwayData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly int $num_gold_coins,
        public readonly int $num_silver_coins,
        public readonly bool $need_complete_in_order,
    ) {
    }

    public static function fromRequest(Request $request, $pathWay): PathwayData
    {
        return new self(
            id: $pathWay->id,
            name: $request->name,
            description: $request->description,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            need_complete_in_order: $request->need_complete_in_order,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'num_gold_coins' => $this->num_gold_coins,
            'num_silver_coins' => $this->num_silver_coins,
            'need_complete_in_order' => $this->need_complete_in_order,
        ];
    }
}
