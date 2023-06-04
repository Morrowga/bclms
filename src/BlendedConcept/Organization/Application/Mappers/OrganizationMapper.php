<?php

namespace Src\BlendedConcept\Organization\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Plan;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;

class OrganizationMapper
{
    public static function fromRequest(Request $request, $organizaton_id = null): Organization
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

        return new Organization(
            id: $organizaton_id,
            plan_id: $request->plan_id,
            name: $request->name,
            description: $request->description,
            type: $request->type,
            contact_person: $request->contact_person,
            contact_email: $request->contact_email,
            contact_number: $request->contact_number,
            plan: PlanMapper::fromArray($planitems)
        );
    }


    public static function toEloquent(Organization $organization): OrganizationEloquentModel
    {
        $organizatonEloquent = new OrganizationEloquentModel();

        if ($organization->id) {
            $organizatonEloquent = OrganizationEloquentModel::query()->findOrFail($organization->id);
        }

        $organizatonEloquent->id = $organization->id;
        $organizatonEloquent->plan_id = $organization->plan_id;
        $organizatonEloquent->name = $organization->name;
        $organizatonEloquent->description = $organization->description;
        $organizatonEloquent->type = $organization->type;
        $organizatonEloquent->contact_person = $organization->contact_person;
        $organizatonEloquent->contact_email = $organization->contact_email;
        $organizatonEloquent->contact_number = $organization->contact_number;
        return $organizatonEloquent;
    }
}
