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
            file_src : $request->file_src,
            gold_coins : $request->gold_coins,
            silver_coins : $request->silver_coins,
            status : $request->status,
            rarity : $request->rarity,
        );
    }



    public static function toEloquent(Reward $reward): RewardEloquentModel
    {
        $rewardEloquent = new RewardEloquentModel();

        if ($reward->id) {
            $rewardEloquent = RewardEloquentModel::query()->findOrFail($game->id);
        }
        $rewardEloquent->id = $reward->id;
        $rewardEloquent->file_src = $reward->file_src;
        $rewardEloquent->gold_coins = $reward->gold_coins;
        $rewardEloquent->silver_coins = $reward->silver_coins;
        $rewardEloquent->status = $reward->status;
        $rewardEloquent->rarity = $reward->rarity;
        return $rewardEloquent;
    }
}
