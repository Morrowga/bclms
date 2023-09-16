<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;

class RewardData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $file_src,
        public readonly int $gold_coins,
        public readonly int $silver_coins,
        public readonly string $status,
        public readonly string $rarity,
    ) {
    }

    public static function fromRequest(Request $request, $reward_id): RewardData
    {
        return new self(
            id: $reward_id,
            file_src: $request->file_src,
            gold_coins: $request->gold_coins,
            silver_coins: $request->silver_coins,
            status: $request->status,
            rarity: $request->rarity,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'file_src' => $this->file_src,
            'gold_coins' => $this->gold_coins,
            'silver_coins' => $this->silver_coins,
            'status' => $this->status,
            'rarity' => $this->rarity,
        ];
    }
}
