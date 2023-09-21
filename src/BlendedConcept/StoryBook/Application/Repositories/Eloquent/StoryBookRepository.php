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
    /**
     * Get a collection of storybooks based on the provided filters.
     *
     * @param  array  $filters The filters to be applied
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * Author @hareom284
     */
    public function getStoryBooks($filters)
    {
        // Retrieve storybooks with relationships, order by id in descending order, and paginate the results
        $storyBooks = StoryBookResource::collection(
            StoryBookEloquentModel::with(['learningneeds', 'themes', 'disability_types', 'devices', 'physical_resources', 'tags'])
                ->orderBy('id', 'desc')
                ->paginate($filters['perPage'] ?? 10)
        );

        return $storyBooks;
    }

    public function getStoryBooksForSelect()
    {
        // Retrieve storybooks with relationships, order by id in descending order, and paginate the results
        $storyBooks = StoryBookEloquentModel::select('name', 'id', 'thumbnail_img')->get();

        return $storyBooks;
    }

    /**
     * Create a new storybook based on the provided StoryBook model.
     *
     * @param  StoryBook  $storyBook The StoryBook model that used for static type on ddd pattern
     * @return void
     * Author @hareom284
     */
    public function createStoryBook(StoryBook $storyBook)
    {
        DB::beginTransaction();

        try {
            // Map the StoryBook model to Eloquent
            $storybookEloquent = StoryBookMapper::toEloquent($storyBook);
            $storybookEloquent->save();
            // Sync related databases
            $storybookEloquent->learningneeds()->sync(request()->sub_learning_needs);
            $storybookEloquent->themes()->sync(request()->themes);
            $storybookEloquent->disability_types()->sync(request()->disability_type);
            $storybookEloquent->devices()->sync(request()->devices);

            // Associate tags
            $storybookEloquent->associateTags(request()->tags);

            // Add media to media library
            if (request()->hasFile('thumbnail_img') && request()->file('thumbnail_img')->isValid()) {
                $storybookEloquent->addMediaFromRequest('thumbnail_img')
                    ->toMediaCollection('thumbnail_img', 'media_storybook');
            }
            if (request()->hasFile('storybook_file') && request()->file('storybook_file')->isValid()) {
                $storybookEloquent->addMediaFromRequest('storybook_file')
                    ->toMediaCollection('storybook_file', 'media_storybook');
            }
            if (request()->hasFile('physical_resource_src') && request()->file('physical_resource_src')->isValid()) {
                $storybookEloquent->addMediaFromRequest('physical_resource_src')
                    ->toMediaCollection('physical_resource_src', 'media_storybook');

                $storybookEloquent->physical_resources()->create([
                    'file_src' => $storybookEloquent->getMedia('physical_resource_src')[0]->original_url,
                ]);
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage(), $error->getLine());
        }
    }

    /**
     * Update an existing storybook based on the provided StoryBookData.
     *
     * @param  StoryBookData  $storyBookData The StoryBookData that used as a Data Tranfer Object on DDD pattern
     * @return void
     */
    public function updateStoryBook(StoryBookData $storyBookData)
    {
        DB::beginTransaction();

        try {
            // Convert StoryBookData to an array
            $storyBookArray = $storyBookData->toArray();

            // Find the storybook by ID and fill with the updated data
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

    /**
     * Get all sub learning needs.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLearningNeed()
    {
        // Retrieve all sub learning needs
        $learningNeeds = SubLearningTypeEloquentModel::get(['id', 'name']);

        return $learningNeeds;
    }

    /**
     * Get all themes.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getthemes()
    {
        // Retrieve all themes
        $themes = ThemeEloquentModel::get(['id', 'name']);

        return $themes;
    }

    /**
     * Get all disability types.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getdisabilitytype()
    {
        // Retrieve all disability types
        $disabilityTypes = DisabilityTypeEloquentModel::get(['id', 'name']);

        return $disabilityTypes;
    }

    /**
     * Get all devices.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getdevice()
    {
        // Retrieve all devices
        $devices = DeviceEloquentModel::get(['id', 'name']);

        return $devices;
    }
}
