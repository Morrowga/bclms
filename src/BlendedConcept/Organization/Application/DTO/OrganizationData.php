<?php

namespace Src\BlendedConcept\Security\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;

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
    ) {
    }

    public static function fromRequest(Request $request, $organizaton_id = null): OrganizationData
    {

        return new self(
            id: $organizaton_id,
            plan_id: $request->plan_id,
            name: $request->name,
            description: $request->description,
            type: $request->type,
            contact_person: $request->contact_person,
            contact_email: $request->contact_email,
            contact_number: $request->contact_number
        );
    }

    public static function fromEloquent(OrganizationEloquentModel $organization): self
    {
        return new self(
            id: $organization->id,
            plan_id: $organization->plan_id,
            name: $organization->name,
            description: $organization->description,
            type: $organization->type,
            contact_person: $organization->contact_person,
            contact_email: $organization->contact_email,
            contact_number: $organization->contact_number
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "plan_id" => $this->plan_id,
            "name" => $this->name,
            "description" => $this->description,
            "type" => $this->type,
            "contact_person" => $this->contact_person,
            "contact_email" => $this->contact_email,
            "contact_number" => $this->contact_number
        ];
    }
}
