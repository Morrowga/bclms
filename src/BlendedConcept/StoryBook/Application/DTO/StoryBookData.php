<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;

class StoryBookData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $thumbnail_img,
        public readonly int $num_gold_coins,
        public readonly int $num_silver_coins,
        public readonly bool $is_free,
        public readonly ?array $tags,
        public readonly ?array $sub_learning_needs,
        public readonly ?array $themes,
        public readonly ?array $disability_type,
        public readonly ?array $devices,
        public readonly ?int $h5p_id,
        public readonly ?array $delete_tags,
        public readonly ?string $type,
    ) {
    }

    public static function fromRequest(Request $request, $storybook_id): StoryBookData
    {
        return new self(
            id: $storybook_id,
            name: $request->name,
            description: $request->description,
            thumbnail_img: $request->thumbnail_img,
            is_free: $request->is_free,
            tags: $request->tags,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            sub_learning_needs: $request->sub_learning_needs,
            themes: $request->themes,
            disability_type: $request->disability_type,
            devices: $request->devices,
            h5p_id: $request->h5p_id,
            delete_tags: $request->delete_tags,
            type: $request->type,
        );
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
            'delete_tags' => $this->delete_tags,
            'type' => $this->type
        ];
    }
}
