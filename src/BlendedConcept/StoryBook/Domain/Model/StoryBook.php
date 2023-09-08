<?php

namespace Src\BlendedConcept\StoryBook\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class StoryBook extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $thumbnail_img,
        public readonly int $num_gold_coins,
        public readonly int $num_silver_coins,
        public readonly bool $is_free,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'thumbnail_img' => $this->thumbnail_img,
            'num_gold_coins' => $this->num_gold_coins,
            'num_silver_coins' => $this->num_silver_coins,
            'is_free' => $this->is_free,
        ];
    }
}
