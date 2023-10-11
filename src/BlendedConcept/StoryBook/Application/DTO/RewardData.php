<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;

class RewardData
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $name,
        public readonly ?string $file_src,
        public readonly ?string $description,
        public readonly ?int $gold_coins_needed,
        public readonly ?int $silver_coins_needed,
        public readonly ?string $rarity,
        public readonly ?float $x_axis_position,
        public readonly ?float $y_axis_position,
        public readonly ?int $sticker_id
    ) {
    }

    public static function fromRequest(Request $request, $reward_id): RewardData
    {
        return new self(
            id: $reward_id,
            name: $request->name,
            description: $request->description,
            file_src: $request->file_src,
            gold_coins_needed: $request->gold_coins_needed,
            silver_coins_needed: $request->silver_coins_needed,
            rarity: $request->rarity,
            x_axis_position: $request->x_axis_position,
            y_axis_position: $request->y_axis_position,
            sticker_id: $request->sticker_id
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_src' => $this->file_src,
            'description' => $this->description,
            'gold_coins_needed' => $this->gold_coins_needed,
            'silver_coins_needed' => $this->silver_coins_needed,
            'rarity' => $this->rarity,
            'x_axis_position' => $this->x_axis_position,
            'y_axis_position' => $this->y_axis_position,
            'sticker_id' => $this->sticker_id
        ];
    }
}
