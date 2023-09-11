<?php

namespace Src\BlendedConcept\FInance\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;

class PlanData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $storage_limit,
        public readonly int $num_student_profiles,
        public readonly bool $allow_customisation,
        public readonly bool $allow_personalisation,
        public readonly bool $full_library_access,
        public readonly bool $concurrent_access,
        public readonly bool $weekly_learning_report,
        public readonly bool $dedicated_student_report,
        public readonly string $status,
        public readonly float $price,
        public readonly string $payment_period,
    ) {
    }

    public static function fromRequest(Request $request, $plan): PlanData
    {
        return new self(
            id: $plan->id,
            name: $request->name,
            description: $request->description,
            storage_limit: $request->storage_limit,
            num_student_profiles: $request->num_student_profiles,
            allow_customisation: $request->allow_customisation,
            allow_personalisation: $request->allow_personalisation,
            full_library_access: $request->full_library_access,
            concurrent_access: $request->concurrent_access,
            weekly_learning_report: $request->weekly_learning_report,
            dedicated_student_report: $request->dedicated_student_report,
            status: $request->status,
            price: $request->price,
            payment_period: $request->payment_period,
        );
    }

    public static function fromEloquent(PlanEloquentModel $plan): self
    {
        return new self(
            id: $plan->id,
            name: $plan->name,
            description: $plan->description,
            storage_limit: $plan->storage_limit,
            num_student_profiles: $plan->num_student_profiles,
            allow_customisation: $plan->allow_customisation,
            allow_personalisation: $plan->allow_personalisation,
            full_library_access: $plan->full_library_access,
            concurrent_access: $plan->concurrent_access,
            weekly_learning_report: $plan->weekly_learning_report,
            dedicated_student_report: $plan->dedicated_student_report,
            status: $plan->status,
            price: $plan->price,
            payment_period: $plan->payment_period,
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "storage_limit" => $this->storage_limit,
            "num_student_profiles" => $this->num_student_profiles,
            "allow_customisation" => $this->allow_customisation,
            "allow_personalisation" => $this->allow_personalisation,
            "full_library_access" => $this->full_library_access,
            "concurrent_access" => $this->concurrent_access,
            "weekly_learning_report" => $this->weekly_learning_report,
            "dedicated_student_report" => $this->dedicated_student_report,
            "status" => $this->status,
            "price" => $this->price,
            "payment_period" => $this->payment_period,
        ];
    }
}
