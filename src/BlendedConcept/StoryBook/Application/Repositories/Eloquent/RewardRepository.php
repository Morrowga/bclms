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
    /**
     * Get a collection of rewards based on the provided filters.
     *
     * @param  array  $filters The filters to be applied
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getRewards($filters)
    {
        // Retrieve rewards based on filters, order by id in descending order, and paginate the results
        $rewards = RewardResource::collection(
            RewardEloquentModel::filter($filters)
                ->orderBy('id', 'desc')
                ->paginate($filters['perPage'] ?? 10)
        );

        return $rewards;
    }

    /**
     * Create a new reward based on the provided request data.
     *
     * @param    $request The request data
     * @return void
     */
    public function createReward($request)
    {
        DB::beginTransaction();

        try {
            // Map the request data to the Eloquent model
            $rewardEloquent = RewardMapper::toEloquent($request);
            $rewardEloquent->status = 'INACTIVE';
            $rewardEloquent->save();

            // Check if an image file was uploaded and is valid
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                // Add the image to the media collection
                $rewardEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_reward');
            }

            // Update the file_src if media exists
            if ($rewardEloquent->getMedia('image')->isNotEmpty()) {
                $rewardEloquent->file_src = $rewardEloquent->getMedia('image')[0]->original_url;
                $rewardEloquent->update();
            }

            DB::commit();
        } catch (\Exception $error) {
            // Handle any exceptions and display the error message
            dd($error->getMessage());
            DB::rollBack();
        }
    }

    /**
     * Update an existing reward based on the provided reward data.
     *
     * @param  \App\Models\RewardData  $reward The reward data
     * @return void
     */
    public function updateReward(RewardData $reward)
    {
        // Author: @hareom284

        DB::beginTransaction();

        try {
            $rewardArray = $reward->toArray();
            $rewardEloquent = RewardEloquentModel::query()->findOrFail($reward->id);
            $rewardEloquent->fill($rewardArray);
            $rewardEloquent->update();

            // Check if an image file was uploaded and is valid
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                // Delete the old image and add the new image to the media collection
                $oldImage = $rewardEloquent->getFirstMedia('image');
                if ($oldImage) {
                    $oldImage->delete();
                }
                $rewardEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_reward');
            }

            // Update the file_src if media exists
            if ($rewardEloquent->getMedia('image')->isNotEmpty()) {
                $rewardEloquent->file_src = $rewardEloquent->getMedia('image')[0]->original_url;
                $rewardEloquent->update();
            }

            DB::commit();
        } catch (\Exception $error) {
            // Handle any exceptions and display the error message
            dd($error->getMessage());
            DB::rollBack();
        }
    }

    public function delete(int $annountment_id)
    {
    }

    /**
     * Change the status of a specific reward to 'INACTIVE'.
     *
     * @param  RewardEloquentModel  $reward The reward to update
     * @return void
     * Author @hareom284
     */
    public function changeStatus($reward)
    {
        // Update the status of the reward to 'INACTIVE'
        $reward->update([
            'status' => 'INACTIVE',
        ]);
    }
}
