<?php

namespace Src\BlendedConcept\Security\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Model\Plan;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\PlanEloquentModel;

class PlanMapper
{
    public static function fromRequest(Request $request, $plan_id = null): Plan
    {
        return new Plan(
            id: $plan_id,
            stripe_id: $request->stripe_id,
            name: $request->name,
            description: $request->description,
            price: $request->price,
            payment_period: $request->payment_period,
            allocated_storage: $request->allocated_storage,
            teacher_license: $request->teacher_license,
            student_license: $request->student_license,
            is_hidden: $request->is_hidden
        );
    }


    public static function toEloquent(Plan $plan): PlanEloquentModel
    {
        $planEloquent = new OrganizationEloquentModel();

        if ($plan->id) {
            $planEloquent = PlanEloquentModel::query()->findOrFail($plan->id);
        }

        $planEloquent->id = $plan->id;
        $planEloquent->stripe_id = $plan->stripe_id;
        $planEloquent->name = $plan->name;
        $planEloquent->description = $plan->description;
        $planEloquent->price = $plan->price;
        $planEloquent->payment_period = $plan->payment_period;
        $planEloquent->allocated_storage = $plan->allocated_storage;
        $planEloquent->teacher_license = $plan->teacher_license;
        $planEloquent->student_license = $plan->student_license;
        $planEloquent->is_hidden = $plan->is_hidden;

        return $planEloquent;
    }
}
