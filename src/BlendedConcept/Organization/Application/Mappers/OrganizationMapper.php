<?php

namespace Src\BlendedConcept\Organization\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Application\Mappers\SubscriptionMapper;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;


class OrganizationMapper
{
    public static function fromRequest(Request $request, $organization_id = null): Organization
    {

        return new Organization(
            id: $organization_id,
            curr_subscription_id: $request->curr_subscription_id,
            org_admin_id: $request->org_admin_id,
            name: $request->name,
            contact_name: $request->contact_name,
            contact_email: $request->contact_email,
            contact_number: $request->contact_number,
            sub_domain: $request->sub_domain,
            logo: $request->logo,
            status: $request->status,

        );
    }

    public static function toEloquent(Organization $organization): OrganizationEloquentModel
    {
        $organizatonEloquent = new OrganizationEloquentModel();

        if ($organization->id) {
            $organizatonEloquent = OrganizationEloquentModel::query()->findOrFail($organization->id);
        }

        $organizatonEloquent->id = $organization->id;
        $organizatonEloquent->curr_subscription_id = $organization->curr_subscription_id;
        $organizatonEloquent->org_admin_id = $organization->org_admin_id;
        $organizatonEloquent->name = $organization->name;
        $organizatonEloquent->contact_name = $organization->contact_name;
        $organizatonEloquent->contact_email = $organization->contact_email;
        $organizatonEloquent->contact_number = $organization->contact_number;
        $organizatonEloquent->sub_domain = $organization->sub_domain;
        $organizatonEloquent->logo = $organization->logo;
        $organizatonEloquent->status = $organization->status ?? 'ACTIVE';

        return $organizatonEloquent;
    }
}
