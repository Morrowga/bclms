<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\StoryBook\Application\DTO\PathwayData;
use Src\BlendedConcept\StoryBook\Application\Mappers\PathwayMapper;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Pathway;
use Src\BlendedConcept\StoryBook\Domain\Repositories\PathwayRepositoryInterface;
use Src\BlendedConcept\StoryBook\Domain\Resources\PathwayResource;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\PathwayEloquentModel;

class PathwayRepository implements PathwayRepositoryInterface
{
    public function getPathways($filters)
    {
        $pathways = PathwayResource::collection(PathwayEloquentModel::filter($filters)->with('storybooks')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $pathways;
    }

    /**
     * Create a new Plan with the provided Plan object.
     *
     * @param  Pathway  $pathway The Plan object containing the necessary information.
     * @return void
     */
    public function createPathway(Pathway $pathway)
    {

        DB::beginTransaction();

        try {

            //insert data into plan

            $pathwayEloquent = PathwayMapper::toEloquent($pathway);
            $pathwayEloquent->save();

            $pathwayEloquent->storybooks()->sync(
                collect($pathway->storybooks)->mapWithKeys(function ($storybook, $index) {
                    return [$storybook => ['sequence' => $index + 1]];
                })
            );
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }

        DB::commit();
    }

    //  update plan
    public function updatePathway(PathwayData $pathwayData)
    {

        DB::beginTransaction();

        try {
            $pathwayDataArray = $pathwayData->toArray();
            $pathwayEloquent = PathwayEloquentModel::query()->findOrFail($pathwayData->id);
            $pathwayEloquent->fill($pathwayDataArray);
            $pathwayEloquent->update();

            $pathwayEloquent->storybooks()->sync(
                collect($pathwayData->storybooks)->mapWithKeys(function ($storybook, $index) {
                    return [$storybook => ['sequence' => $index + 1]];
                })
            );
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

        DB::commit();
    }

    public function deletePathway(PathwayEloquentModel $Pathway)
    {
    }
}
