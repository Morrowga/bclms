<?php

namespace Src\BlendedConcept\StoryBook\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Reward extends Entity
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
