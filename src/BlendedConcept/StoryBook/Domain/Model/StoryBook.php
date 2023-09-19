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
        public readonly bool $is_free,
        public readonly array $tags,
        public readonly array $sub_learning_needs,
        public readonly array $themes,
        public readonly array $disability_type,
        public readonly array $devices,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'thumbnail_img' => $this->thumbnail_img,
            'is_free' => $this->is_free,
            'tags' => $this->tags,
            'sub_learning_needs' => $this->sub_learning_needs,
            'themes' => $this->themes,
            'disability_type' => $this->disability_type,
            'devices' => $this->devices,
        ];
    }
}
