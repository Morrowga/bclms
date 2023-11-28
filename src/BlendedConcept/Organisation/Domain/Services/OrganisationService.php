<?php

namespace Src\BlendedConcept\Organisation\Domain\Services;

use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class OrganisationService
{
    public function createQuickOrgAdmin($request)
    {
        $userEloquent = new UserEloquentModel;
        $userEloquent->first_name = $request->org_admin_name;
        $userEloquent->contact_number = $request->org_admin_contact_number;
        $userEloquent->email = $request->login_email;
        $userEloquent->password = $request->login_password;
        $userEloquent->role_id = 5;
        $userEloquent->save();

        return $userEloquent;
    }

    public function updateQuickOrgAdmin($organisation, $request)
    {
        // dd($request->all());
        $userEloquent = UserEloquentModel::find($organisation->org_admin->user_id);

        $userEloquent->first_name = $request->org_admin_name;
        $userEloquent->contact_number = $request->org_admin_contact_number;
        $userEloquent->email = $request->login_email;
        $userEloquent->update();

        return $userEloquent;
    }
}
