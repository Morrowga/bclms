<?php

namespace Src\BlendedConcept\Finance\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\FInance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Finance\Domain\Repositories\SubscriptionRepositoryInterface;
use Src\BlendedConcept\Finance\Domain\Resources\SubscriptionResource;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2bSubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2cSubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function getB2bSubscriptions($filters)
    {
        $subscriptions = SubscriptionResource::collection(SubscriptionEloquentModel::filter($filters)->with('organization', 'b2b_subscription')->whereHas('organization')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $subscriptions;
    }

    public function getB2cSubscriptions($filters)
    {
        $subscriptions = SubscriptionResource::collection(SubscriptionEloquentModel::filter($filters)->with('organization', 'b2c_subscription')
            ->whereDoesntHave('organization')
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10));

        return $subscriptions;
    }

    public function updateB2bSubscription(SubscriptionData $subscriptionData)
    {
        DB::beginTransaction();

        try {
            $subscriptionDataArray = $subscriptionData->toArray();
            $subscriptionEloquent = SubscriptionEloquentModel::query()->findOrFail($subscriptionData->id);
            $subscriptionEloquent->fill($subscriptionDataArray);
            $subscriptionEloquent->update();
            $subscriptionEloquent->load('organization');
            $b2bSubscriptionEloquent = new B2bSubscriptionEloquentModel;
            $b2bSubscriptionEloquent->subscription_id = $subscriptionEloquent->id;
            $b2bSubscriptionEloquent->organization_id = $subscriptionEloquent->organization->id;
            $b2bSubscriptionEloquent->storage_limit = $subscriptionDataArray['b2b_subscription']['storage_limit'];
            $b2bSubscriptionEloquent->num_student_license = $subscriptionDataArray['b2b_subscription']['num_student_license'];
            $b2bSubscriptionEloquent->num_teacher_license = $subscriptionDataArray['b2b_subscription']['num_teacher_license'];
            $b2bSubscriptionEloquent->save();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

        DB::commit();
    }

    public function updateB2cSubscription(SubscriptionData $subscriptionData)
    {
        DB::beginTransaction();

        try {
            $subscriptionDataArray = $subscriptionData->toArray();

            $subscriptionEloquent = SubscriptionEloquentModel::query()->findOrFail($subscriptionData->id);
            $subscriptionEloquent->fill($subscriptionDataArray);
            $subscriptionEloquent->update();
            $b2bSubscriptionEloquent = new B2cSubscriptionEloquentModel();
            $b2bSubscriptionEloquent->subscription_id = $subscriptionEloquent->id;
            $b2bSubscriptionEloquent->plan_id = $subscriptionData->plan_id;
            $b2bSubscriptionEloquent->user_id = $subscriptionData->user_id;
            $b2bSubscriptionEloquent->save();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

        DB::commit();
    }
}
