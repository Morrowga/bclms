<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookVersionRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\StoryBookVersion;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookVersionData;
use Src\BlendedConcept\StoryBook\Application\Mappers\StoryBookVersionMapper;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookVersionEloquentModel;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Review;
use Src\BlendedConcept\StoryBook\Application\Mappers\ReviewMapper;

class StoryBookVersionRepository implements StoryBookVersionRepositoryInterface
{
    public function getStoryBooksWithVersions()
    {
    }


    /****
     *  In the funciton we have to create storyversion that will copy from original storybooks
     *  and b2c and b2b techer can update the setiting on the storybooks
     *  @hareom284
     *
     */

    public function createStoryBookVersion(StoryBookVersion $storyBookVersion,)
    {

        DB::beginTransaction();
        try {
            $storyBookVersionEloquent = StoryBookVersionMapper::toEloquent($storyBookVersion);
            $storyBookVersionEloquent->teacher_id = auth()->user()->id;
            $storyBookVersionEloquent->save();
            DB::commit();
        } catch (\Exception $error) {

            DB::rollBack();
            dd($error->getMessage());
        }
    }

    public function updateStoryBookVersion(StoryBookVersionData $storyBookVersionData)
    {
    }

    public function deleteStoryBookVersion()
    {
    }

    public function assigmentAssigment()
    {
        DB::beginTransaction();
        try {
            $storybookversion = StoryBookVersionEloquentModel::where('storybook_id', request()->storybook_version_id)->first();
            $storybookversion->storybook_assigments()->sync(request()->student_ids);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }
    }

    public function bookreview(Review $review)
    {

        DB::beginTransaction();
        try {
            $createEloquent = ReviewMapper::toEloquent($review);
            $createEloquent->given_by_user_id = auth()->user()->id;
            $createEloquent->given_on = now();
            $createEloquent->save();
            DB::commit();
        } catch (\Exception $error) {
             dd($error->getMessage());
            DB::rollBack();
        }
    }
}
