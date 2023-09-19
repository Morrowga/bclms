<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookData;
use Src\BlendedConcept\StoryBook\Application\Mappers\StoryBookMapper;
use Src\BlendedConcept\StoryBook\Domain\Model\StoryBook;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Resources\StoryBookResource;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class StoryBookRepository implements StoryBookRepositoryInterface
{
    public function getStoryBooks($filters)
    {
        $games = StoryBookResource::collection(StoryBookEloquentModel::with(['learingneeds', 'themes', 'disability_types', 'devices', 'physical_resources', 'tags'])
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10));

        return $games;
    }

    //create storybooks
    public function createStoryBook(StoryBook $storyBook)
    {
        DB::beginTransaction();

        try {
            $storybookElouquent = StoryBookMapper::toEloquent($storyBook);
            $storybookElouquent->save();
            //  synce database with related database

            $storybookElouquent->learingneeds()->sync(request()->sub_learning_needs);
            $storybookElouquent->themes()->sync(request()->themes);
            $storybookElouquent->disability_types()->sync(request()->disability_type);
            $storybookElouquent->devices()->sync(request()->devices);

            $storybookElouquent->associateTags(request()->tags);

            //add media library

            if (request()->hasFile('thumbnail_img') && request()->file('thumbnail_img')->isValid()) {
                $storybookElouquent->addMediaFromRequest('thumbnail_img')
                    ->toMediaCollection('thumbnail_img', 'media_storybook');
                // $storybookElouquent->thumbnail_img = $storybookElouquent->getMedia('thumbnail_img')[0]->original_url;
            }
            if (request()->hasFile('storybook_file') && request()->file('storybook_file')->isValid()) {
                $storybookElouquent->addMediaFromRequest('storybook_file')->toMediaCollection('storybook_file', 'media_storybook');
            }
            if (request()->hasFile('physical_resource_src') && request()->file('physical_resource_src')->isValid()) {
                $storybookElouquent->addMediaFromRequest('physical_resource_src')->toMediaCollection('physical_resource_src', 'media_storybook');

                $storybookElouquent->physical_resources()->create([
                    'file_src' => $storybookElouquent->getMedia('physical_resource_src')[0]->original_url,
                ]);
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage(), $error->getLine());
        }
    }

    //update storybooks
    public function updateStoryBook(StoryBookData $storyBookData)
    {

        DB::beginTransaction();
        try {
            $storyBookArray = $storyBookData->toArray();
            $updateStoryBookEloquent = StoryBookEloquentModel::query()->findOrFail($storyBookData->id);
            $updateStoryBookEloquent->fill($storyBookArray);
            $updateStoryBookEloquent->update();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }
    }

    public function deleteStoryBook(int $storybook_id)
    {
    }

    public function getLearningNeed()
    {
        $learningneeds = SubLearningTypeEloquentModel::get();

        return $learningneeds;
    }

    public function getthemes()
    {
        $themes = ThemeEloquentModel::get();

        return $themes;
    }

    public function getdisabilitytype()
    {
        $disability = DisabilityTypeEloquentModel::get();

        return $disability;
    }

    public function getdevice()
    {

        $devices = DeviceEloquentModel::get();

        return $devices;
    }
}
