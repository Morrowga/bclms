<?php

namespace Src\BlendedConcept\Organization\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Application\Mappers\PlanMapper;
use Src\BlendedConcept\Finance\Domain\Model\Entities\Plan;

class OrganizationData
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $plan_id,
        public readonly ?string $name,
        public readonly ?string $description,
        public readonly ?string $type,
        public readonly ?string $contact_person,
        public readonly ?string $contact_email,
        public readonly ?string $contact_number,
        public readonly Plan $plan,
    ) {
    }

    public static function fromRequest(Request $request, $organizaton): OrganizationData
    {

        $planitems = $request->only(
            [
                'stripe_id',
                'name',
                'description',
                'price',
                'payment_period',
                'allocated_storage',
                'teacher_license',
                'student_license',
                'is_hidden',
            ]
        );

        return new self(
            id: $organizaton->id,
            plan_id: $organizaton->plan_id,
            name: $request->name,
            description: $request->description,
            type: $request->type,
            contact_person: $request->contact_person,
            contact_email: $request->contact_email,
            contact_number: $request->contact_number,
            plan: PlanMapper::fromArray($planitems)
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'plan_id' => $this->plan_id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'contact_person' => $this->contact_person,
            'contact_email' => $this->contact_email,
            'contact_number' => $this->contact_number,
            'plan' => $this->plan,
        ];
    }
}
