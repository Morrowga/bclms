<?php

namespace Src\BlendedConcept\Finance\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\FInance\Application\DTO\PlanData;
use Src\BlendedConcept\Finance\Application\Mappers\PlanMapper;
use Src\BlendedConcept\Finance\Domain\Model\Entities\Plan;
use Src\BlendedConcept\Finance\Domain\Repositories\PlanRepositoryInterface;
use Src\BlendedConcept\Finance\Domain\Resources\PlanResource;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;

class PlanRepository implements PlanRepositoryInterface
{
    public function getPlans($filters)
    {
        $paginate_plans = PlanResource::collection(PlanEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        $default_plans = PlanEloquentModel::get();

        return [
            'paginate_plans' => $paginate_plans,
            'default_plans' => $default_plans,
        ];
    }

    public function getActivePlans($filters)
    {
        $activeplans = PlanResource::collection(PlanEloquentModel::filter($filters)->where('status', PlanEloquentModel::STATUS['active'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $activeplans;
    }

    public function getInactivePlans($filters)
    {
        $inactiveplans = PlanResource::collection(PlanEloquentModel::filter($filters)->where('status', PlanEloquentModel::STATUS['inactive'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $inactiveplans;
    }

    /**
     * Create a new Plan with the provided Plan object.
     *
     * @param  Plan  $plan The Plan object containing the necessary information.
     * @return void
     */
    public function createPlan(Plan $plan)
    {

        DB::beginTransaction();

        try {

            //insert data into plan

            $planEloquent = PlanMapper::toEloquent($plan);
            $planEloquent->save();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }

        DB::commit();
    }

    //  update plan
    public function updatePlan(PlanData $planData)
    {

        DB::beginTransaction();

        try {
            $planDataArray = $planData->toArray();
            $planEloquent = PlanEloquentModel::query()->findOrFail($planData->id);
            $planEloquent->fill($planDataArray);
            $planEloquent->update();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

        DB::commit();
    }

    //  update plan
    public function changeStatus($request, $planEloquent)
    {
        DB::beginTransaction();

        try {
            $planEloquent->status = $request->status;
            $planEloquent->update();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

        DB::commit();
    }
}
