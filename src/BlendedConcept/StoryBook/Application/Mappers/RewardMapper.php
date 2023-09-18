<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Reward;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\RewardEloquentModel;

class RewardMapper
{
    public static function fromRequest(Request $request, $reward_id = null): Reward
    {
        return new Reward(

            id : $reward_id,
            name : $request->name,
            description : $request->description,
            file_src : $request->file_src,
            gold_coins_needed : $request->gold_coins_needed,
            silver_coins_needed : $request->silver_coins_needed,
            rarity : $request->rarity,
        );
    }

    public static function toEloquent(Reward $reward): RewardEloquentModel
    {
        $rewardEloquent = new RewardEloquentModel();

        if ($reward->id) {
            $rewardEloquent = RewardEloquentModel::query()->findOrFail($reward->id);
        }
        $rewardEloquent->id = $reward->id;
        $rewardEloquent->name = $reward->name;
        $rewardEloquent->file_src = $reward->file_src;
        $rewardEloquent->description = $reward->description;
        $rewardEloquent->gold_coins_needed = $reward->gold_coins_needed;
        $rewardEloquent->silver_coins_needed = $reward->silver_coins_needed;
        $rewardEloquent->rarity = $reward->rarity;

        return $rewardEloquent;
    }
}
