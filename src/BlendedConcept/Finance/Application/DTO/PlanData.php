<?php

namespace Src\BlendedConcept\FInance\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;

class PlanData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly float $storage_limit,
        public readonly int $num_student_license,
        public readonly bool $allow_customisation,
        public readonly bool $allow_personalisation,
        public readonly string $status,
        public readonly float $price,
        public readonly string $payment_period,
    ) {
    }

    public static function fromRequest(Request $request, $plan_id = null): PlanData
    {
        return new self(
            id : $plan_id,
            name : $request->name,
            storage_limit : $request->storage_limit,
            num_student_license : $request->num_student_license,
            allow_customisation : $request->allow_customisation,
            allow_personalisation : $request->allow_personalisation,
            status : $request->status,
            price : $request->price,
            payment_period : $request->payment_period,
        );
    }

    public static function fromEloquent(PlanEloquentModel $plan): self
    {
        return new self(
            id : $plan->id,
            name : $plan->name,
            storage_limit : $plan->storage_limit,
            num_student_license : $plan->num_student_license,
            allow_customisation : $plan->allow_customisation,
            allow_personalisation : $plan->allow_personalisation,
            status : $plan->status,
            price : $plan->price,
            payment_period : $plan->payment_period,
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "storage_limit" => $this->storage_limit,
            "num_student_license" => $this->num_student_license,
            "allow_customisation" => $this->allow_customisation,
            "allow_personalisation" => $this->allow_personalisation,
            "status" => $this->status,
            "price" => $this->price,
            "payment_period" => $this->payment_period
        ];
    }
}
