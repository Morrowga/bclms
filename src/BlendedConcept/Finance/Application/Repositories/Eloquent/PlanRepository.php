<?php

namespace Src\BlendedConcept\Finance\Application\Repositories\Eloquent;

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
}
