<?php

namespace Src\BlendedConcept\FInance\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2bSubscriptionEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;

class B2bSubscriptionData
{
    public function __construct(
        public readonly ?int $subscription_id,
        public readonly ?string $organization_id,
        public readonly ?string $receipt_image,
        public readonly ?string $storage_limit,
        public readonly ?string $num_teacher_license,
        public readonly ?string $num_student_license,
    ) {
    }

    public static function fromRequest(Request $request, $b2bSubscription): B2bSubscriptionData
    {
        return new self(
            subscription_id: $b2bSubscription->subscription_id,
            organization_id: $b2bSubscription->organization_id,
            receipt_image: $request->end_date,
            storage_limit: $request->payment_date,
            num_teacher_license: $request->payment_status,
            num_student_license: $request->stripe_status
        );
    }

    public static function fromEloquent(B2bSubscriptionEloquentModel $b2bSubscription): self
    {
        return new self(
            subscription_id: $b2bSubscription->b2bSubscription_id,
            organization_id: $b2bSubscription->organization_id,
            receipt_image: $b2bSubscription->receipt_image,
            storage_limit: $b2bSubscription->storage_limit,
            num_teacher_license: $b2bSubscription->num_teacher_license,
            num_student_license: $b2bSubscription->num_student_license,
        );
    }

    public function toArray(): array
    {
        return [
            'subscription_id' => $this->subscription_id,
            'organization_id' => $this->organization_id,
            'receipt_image' => $this->receipt_image,
            'storage_limit' => $this->storage_limit,
            'num_teacher_license' => $this->num_teacher_license,
            'num_student_license' => $this->num_student_license,
        ];
    }
}
