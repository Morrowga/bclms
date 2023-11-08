<?php

namespace Src\BlendedConcept\StoryBook\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class StoryBook extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly ?string $thumbnail_img,
        public readonly int $num_gold_coins,
        public readonly int $num_silver_coins,
        public readonly bool $is_free,
        public readonly array $tags,
        public readonly array $sub_learning_needs,
        public readonly array $themes,
        public readonly array $disability_type,
        public readonly array $devices,
        public readonly ?int $h5p_id,
        public readonly ?string $type
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
            'tags' => $this->tags,
            'sub_learning_needs' => $this->sub_learning_needs,
            'themes' => $this->themes,
            'disability_type' => $this->disability_type,
            'devices' => $this->devices,
            'h5p_id' => $this->h5p_id,
            'type' => $this->type
        ];
    }
}
