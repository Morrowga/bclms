<?php

namespace Src\BlendedConcept\Finance\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Domain\Model\Entities\Plan;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;

class PlanMapper
{
    public static function fromRequest(Request $request, $plan_id = null): Plan
    {
        return new Plan(
            id: $plan_id,
            name: $request->name,
            storage_limit: $request->storage_limit,
            num_student_license: $request->num_student_license,
            allow_customisation: $request->allow_customisation,
            allow_personalisation: $request->allow_personalisation,
            status: $request->status,
            price: $request->price,
            payment_period: $request->payment_period,
        );
    }

    public static function fromArray(array $plan): Plan
    {
        $planEloquent = new PlanEloquentModel($plan);
        $planEloquent->id = $plan['id'] ?? null;

        return self::fromEloquent($planEloquent);
    }

    public static function fromEloquent(PlanEloquentModel $plan): Plan
    {
        return new Plan(
            id: $plan->id,
            name: $plan->name,
            storage_limit: $plan->storage_limit,
            num_student_license: $plan->num_student_license,
            allow_customisation: $plan->allow_customisation,
            allow_personalisation: $plan->allow_personalisation,
            status: $plan->status,
            price: $plan->price,
            payment_period: $plan->payment_period,
        );
    }

    public static function toEloquent(Plan $plan): PlanEloquentModel
    {
        $planEloquent = new PlanEloquentModel();

        if ($plan->id) {
            $planEloquent = PlanEloquentModel::query()->findOrFail($plan->id);
        }
        $planEloquent->name = $plan->name;
        $planEloquent->storage_limit = $plan->storage_limit;
        $planEloquent->num_student_license = $plan->num_student_license;
        $planEloquent->allow_customisation = $plan->allow_customisation;
        $planEloquent->allow_personalisation = $plan->allow_personalisation;
        $planEloquent->status = $plan->status;
        $planEloquent->price = $plan->price;
        $planEloquent->payment_period = $plan->payment_period;

        return $planEloquent;
    }
}
