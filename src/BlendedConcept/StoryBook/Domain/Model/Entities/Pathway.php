<?php

namespace Src\BlendedConcept\StoryBook\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Pathway extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly int $num_gold_coins,
        public readonly int $num_silver_coins,
        public readonly bool $need_complete_in_order,
        public readonly ?array $storybooks,
    ) {
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
