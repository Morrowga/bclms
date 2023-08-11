<?php

namespace Src\BlendedConcept\Organization\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Plan;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\PlanEloquentModel;

class PlanMapper
{
    public static function fromRequest(Request $request, $plan_id = null): Plan
    {
        return new Plan(
            id: $plan_id,
            stripe_id: $request->stripe_id,
            name: 'Default Plan',
            description: $request->description,
            price: $request->price,
            payment_period: $request->payment_period,
            allocated_storage: $request->storage,
            teacher_license: $request->teacher_license,
            student_license: $request->student_license,
            is_hidden: $request->is_hidden
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
            stripe_id: $plan->stripe_id,
            name: $plan->name,
            description: $plan->description,
            price: $plan->price,
            payment_period: $plan->payment_period,
            allocated_storage: $plan->allocated_storage,
            teacher_license: $plan->teacher_license,
            student_license: $plan->student_license,
            is_hidden: $plan->is_hidden
        );
    }

    public static function toEloquent(Plan $plan): PlanEloquentModel
    {
        $planEloquent = new PlanEloquentModel();

        if ($plan->id) {
            $planEloquent = PlanEloquentModel::query()->findOrFail($plan->id);
        }

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
