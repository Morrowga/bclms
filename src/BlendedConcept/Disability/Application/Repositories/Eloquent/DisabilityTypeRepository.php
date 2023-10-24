<?php

namespace Src\BlendedConcept\Disability\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Disability\Application\DTO\DisabilityTypeData;
use Src\BlendedConcept\Disability\Application\Mappers\DisabilityTypeMapper;
use Src\BlendedConcept\Disability\Domain\Model\DisabilityType;
use Src\BlendedConcept\Disability\Domain\Repositories\DisabilityTypeRepositoryInterface;
use Src\BlendedConcept\Disability\Domain\Resources\DisabilityTypeResource;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class DisabilityTypeRepository implements DisabilityTypeRepositoryInterface
{
    public function getDisabilityTypes($filters)
    {

        $disabilityTypes = DisabilityTypeResource::collection(DisabilityTypeEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $disabilityTypes;
    }

    public function showDisabilityTypes()
    {

        $disabilityTypes = DisabilityTypeResource::collection(DisabilityTypeEloquentModel::orderBy('id', 'desc')->get());

        return $disabilityTypes;
    }

    public function createDisability(DisabilityType $disabilityType)
    {
        DB::beginTransaction();
        try {
            $disabilityType = DisabilityTypeMapper::toEloquent($disabilityType);
            $disabilityType->save();
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    public function updateDisability(DisabilityTypeData $disabilityTypeData)
    {
        DB::beginTransaction();
        try {
            $disabilityTypeArray = $disabilityTypeData->toArray();
            $disabilityTypeEloquent = DisabilityTypeEloquentModel::findOrFail($disabilityTypeData->id);
            $disabilityTypeEloquent->fill($disabilityTypeArray);
            $disabilityTypeEloquent->update();
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    public function deleteDisability(DisabilityTypeEloquentModel $disabilityType)
    {
        DB::beginTransaction();
        try {
            $disabilityType->delete();
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    public function getdisabilitytypeForSelect()
    {

        $disabilityTypes = DisabilityTypeEloquentModel::orderBy('id', 'desc')->select('name', 'id')->get();

        return $disabilityTypes;
    }
}
