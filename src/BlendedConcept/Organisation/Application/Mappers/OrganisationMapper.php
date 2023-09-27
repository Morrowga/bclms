<?php

namespace Src\BlendedConcept\Organisation\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Organisation\Domain\Model\Organisation;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

class OrganisationMapper
{
    public static function fromRequest(Request $request, $organisation_id = null): Organisation
    {

        return new Organisation(
            id: $organisation_id,
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

    public static function toEloquent(Organisation $organisation): OrganisationEloquentModel
    {
        $organizatonEloquent = new OrganisationEloquentModel();

        if ($organisation->id) {
            $organizatonEloquent = OrganisationEloquentModel::query()->findOrFail($organisation->id);
        }

        $organizatonEloquent->id = $organisation->id;
        $organizatonEloquent->curr_subscription_id = $organisation->curr_subscription_id;
        $organizatonEloquent->org_admin_id = $organisation->org_admin_id;
        $organizatonEloquent->name = $organisation->name;
        $organizatonEloquent->contact_name = $organisation->contact_name;
        $organizatonEloquent->contact_email = $organisation->contact_email;
        $organizatonEloquent->contact_number = $organisation->contact_number;
        $organizatonEloquent->sub_domain = $organiation->sub_domain;
        $organizatonEloquent->logo = $organisation->logo;
        $organizatonEloquent->status = $organisation->status ?? 'ACTIVE';

        return $organizatonEloquent;
    }
}
