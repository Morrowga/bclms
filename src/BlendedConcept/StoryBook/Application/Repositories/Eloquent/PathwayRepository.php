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
        $pathways = PathwayResource::collection(PathwayEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $pathways;
    }

    /**
     * Create a new Plan with the provided Plan object.
     *
     * @param  Plan  $plan The Plan object containing the necessary information.
     * @return void
     */
    public function createPathway(Pathway $pathway)
    {

        DB::beginTransaction();

        try {

            //insert data into plan

            $planEloquent = PathwayMapper::toEloquent($pathway);
            $planEloquent->save();
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
