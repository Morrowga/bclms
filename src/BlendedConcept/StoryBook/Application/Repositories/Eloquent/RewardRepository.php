<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\StoryBook\Application\DTO\RewardData;
use Src\BlendedConcept\StoryBook\Domain\Resources\RewardResource;
use Src\BlendedConcept\StoryBook\Application\Mappers\RewardMapper;
use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
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
            $rewardEloquent->status = 'ACTIVE';
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
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
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
            DB::rollBack();
            // Handle any exceptions and display the error message
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
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
        if ($reward->status == "INACTIVE") {
            $reward->update([
                'status' => 'ACTIVE',
            ]);
        } else {
            $reward->update([
                'status' => 'INACTIVE',
            ]);
        }
    }

    public function ownSticker($reward)
    {

        DB::beginTransaction();
        try {
            $student = auth()->user()->student;
            $coin_type = request('coin_type');

            if ($coin_type == 'gold' && $student->num_gold_coins <= 0) {
                return throw new \Exception("Gold Coins Not Enough!");
            }
            if ($coin_type == 'silver' && $student->num_silver_coins <= 0) {
                return throw new \Exception("Silver Coins Not Enough!");
            } else {
                if ($coin_type == 'gold') {

                    $rest_gold_coins = $student->num_gold_coins - $reward->gold_coins_needed;
                    $student->update([
                        "num_gold_coins" => $rest_gold_coins
                    ]);
                } else {
                    $rest_silver_coins = $student->num_silver_coins - $reward->silver_coins_needed;
                    $student->update([

                        "num_silver_coins" => $rest_silver_coins
                    ]);
                }

                $data = $reward->students()->attach([$student->student_id]);
            }
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($e->getMessage());
        }
    }

    public function dropSticker($rewardData)
    {
        DB::beginTransaction();
        try {

            $student = auth()->user()->student;
            $rewardArray = $rewardData->toArray();
            $sticker = DB::table('student_sticker')->where('id', $rewardData->sticker_id);

            $sticker->update([
                'x_axis_position' => $rewardArray['x_axis_position'],
                'y_axis_position' => $rewardArray['y_axis_position']
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($e->getMessage());
        }
    }

    public function getStickerRollData($count)
    {
        DB::beginTransaction();
        try {
            $stickers = $this->rollSystem($count);
            DB::commit();

            return $stickers;
        } catch (\Exception $e) {

            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($e->getMessage());
        }
    }

    public function rollSystem($time)
    {
        $numberOfRolls = $time;

        // $rarityProbabilities = [
        //     'LEGENDARY' => 0.01,
        //     'EPIC' => 0.05,
        //     'SUPERRARE' => 0.10,
        //     'RARE' => 0.20,
        //     'COMMON' => 0.64,
        // ];

        // $selectedRarities = [];

        // // Generate the selected rarities based on probabilities
        // for ($i = 0; $i < $numberOfRolls; $i++) {
        //     $randomNumber = mt_rand() / mt_getrandmax();
        //     $selectedRarity = '';

        //     foreach ($rarityProbabilities as $rarity => $probability) {
        //         if ($randomNumber < $probability) {
        //             $selectedRarity = $rarity;
        //             break;
        //         } else {
        //             $randomNumber -= $probability;
        //         }
        //     }

        //     $selectedRarities[] = $selectedRarity;
        // }

        if ($time == 1) {
            // $student
            // whereIn('rarity', $selectedRarities)
            $records = RewardEloquentModel::where('status', 'ACTIVE')
                ->inRandomOrder()
                ->first();

            if (!empty($records)) {
                $student = auth()->user()->student;
                $student->stickers()->attach([$records->id]);
                $coinUpdate = StudentEloquentModel::find($student->student_id);
                $coinUpdate->num_gold_coins -= 1;
                $coinUpdate->save();
            }
        } else {
            // whereIn('rarity', $selectedRarities)
            $records = RewardEloquentModel::where('status', 'ACTIVE')
                ->inRandomOrder()
                ->limit($time)->get();

            if ($records->count() > 0) {
                $ids = $records->pluck('id');

                $student = auth()->user()->student;
                $student->stickers()->attach($ids);

                $coinUpdate = StudentEloquentModel::find($student->student_id);
                $coinUpdate->num_gold_coins -= 8;
                $coinUpdate->save();
            }
        }
        // Fetch records based on the selected rarities
        return $records ?? '';
    }

    public function getStudentsReward()
    {
        $student = auth()->user()->student;
        // $stickers = RewardEloquentModel::with('students')->whereHas('students', function ($query) use ($student) {
        //     $query->where('students.student_id', $student->student_id);
        // })->get();
        $studentEloquent = StudentEloquentModel::with('stickers')->whereHas('stickers', function ($query) use ($student) {
            $query->where('student_sticker.student_id', $student->student_id);
        })->find($student->student_id);
        $placed_stickers = $studentEloquent ? $studentEloquent->stickers : '';
        $stickers = $studentEloquent ? $studentEloquent->stickers()->paginate(6) : '';

        return ["stickers" => $stickers, "placed_stickers" => $placed_stickers];
    }
}
