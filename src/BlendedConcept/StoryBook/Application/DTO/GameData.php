<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;

class GameData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $game_file,
        public readonly ?string $thumbnail,
        public readonly int $num_gold_coins,
        public readonly int $num_silver_coins,
    ) {
    }

    public static function fromRequest(Request $request, $game_id): GameData
    {
        return new self(
            id : $game_id,
            name : $request->name,
            description : $request->description,
            game_file : $request->game_file,
            thumbnail : $request->thumbnail,
            num_gold_coins : $request->num_gold_coins,
            num_silver_coins : $request->num_silver_coins,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'game_file' => $this->game_file,
            'thumbnail' => $this->thumbnail,
            'num_gold_coins' => $this->num_gold_coins,
            'num_silver_coins' => $this->num_silver_coins,
        ];
    }
}
