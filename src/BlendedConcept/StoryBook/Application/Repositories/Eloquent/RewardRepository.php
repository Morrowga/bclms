<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\StoryBook\Application\DTO\RewardData;
use Src\BlendedConcept\StoryBook\Application\Mappers\RewardMapper;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Resources\RewardResource;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\RewardEloquentModel;

class RewardRepository implements RewaredRepositoryInterface
{
    //get all rewards
    public function getRewards($filters)
    {
        $rewards = RewardResource::collection(RewardEloquentModel::filter($filters)
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10));

        return $rewards;
    }

    //create reward
    public function createReward($request)
    {
        DB::beginTransaction();

        try {
            $rewardEloquent = RewardMapper::toEloquent($request);
            $rewardEloquent->status = 'INACTIVE';
            $rewardEloquent->save();

            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $rewardEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_reward');
            }

            if ($rewardEloquent->getMedia('image')->isNotEmpty()) {
                $rewardEloquent->file_src = $rewardEloquent->getMedia('image')[0]->original_url;
                $rewardEloquent->update();
            }

            DB::commit();
        } catch (\Exception $error) {
            dd($error->getMessage());
            DB::rollBack();
        }
    }

    //update reward
    public function updateRewared(RewardData $reward)
    {

        DB::beginTransaction();
        try {

            $rewaredArrary = $reward->toArray();
            $rewardEloquentEloquent = RewardEloquentModel::query()->findOrFail($reward->id);
            $rewardEloquentEloquent->fill($rewaredArrary);
            $rewardEloquentEloquent->update();

            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $old_image = $rewardEloquentEloquent->getFirstMedia('image');
                $old_image->delete();
                $rewardEloquentEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_reward');
            }

            if ($rewardEloquentEloquent->getMedia('image')->isNotEmpty()) {
                $rewardEloquentEloquent->file_src = $rewardEloquentEloquent->getMedia('image')[0]->original_url;
                $rewardEloquentEloquent->update();
            }

            DB::commit();

        } catch (\Exception $error) {
            dd($error->getMessage());
            DB::rollBack();
        }
    }

    public function delete(int $annountment_id)
    {
    }

    public function changeStatus($reward)
    {
        $reward->update([
            'status' => 'INACTIVE',
        ]);
    }
}
