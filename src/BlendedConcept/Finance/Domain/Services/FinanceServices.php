<?php

namespace Src\BlendedConcept\Finance\Domain\Services;

use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2bSubscriptionEloquentModel;

class FinanceServices
{
    public function createSubscriptionRecord($request, $subscription)
    {
        $b2b_subscription = new B2bSubscriptionEloquentModel();
        $b2b_subscription->subscription_id = $subscription->id;
        $b2b_subscription->organisation_id = $subscription->organisation->id;
        $b2b_subscription->storage_limit = $request->storage_limit;
        $b2b_subscription->num_student_license = $request->num_student_license;
        $b2b_subscription->num_teachter_license = $request->num_teacher_license;
        $b2b_subscription->save();
    }
}
