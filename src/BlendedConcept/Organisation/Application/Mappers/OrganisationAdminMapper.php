<?php

namespace Src\BlendedConcept\Organisation\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Organisation\Domain\Model\Entities\OrganisationAdmin;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;

class OrganisationAdminMapper
{
    public static function fromRequest(Request $request, $org_admin_id = null): OrganisationAdmin
    {

        return new OrganisationAdmin(
            org_admin_id: $org_admin_id,
            user_id: $request->user_id,
            organisation_id: $request->organisation_id,

        );
    }

    public static function toEloquent(OrganisationAdmin $organisationAdmin): OrganisationAdminEloquentModel
    {
        $organizatonAdminEloquent = new OrganisationAdminEloquentModel();

        if ($organisationAdmin->org_admin_id) {
            $organizatonAdminEloquent = OrganisationAdminEloquentModel::query()->findOrFail($organisationAdmin->org_admin_id);
        }
        $organizatonAdminEloquent->user_id = $organisationAdmin->user_id;
        $organizatonAdminEloquent->organisation_id = $organisationAdmin->organisation_id;
        return $organizatonAdminEloquent;
    }
}
