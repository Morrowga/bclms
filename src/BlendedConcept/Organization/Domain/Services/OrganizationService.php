<?php

namespace Src\BlendedConcept\Organization\Domain\Services;



use Illuminate\Support\Facades\Hash;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class OrganizationService
{
    public function createQuickOrgAdmin($request)
    {
        $userEloquent = new UserEloquentModel;
        $userEloquent->first_name = $request->org_admin_name;
        $userEloquent->contact_number = $request->org_admin_contact_number;
        $userEloquent->email = $request->login_email;
        $userEloquent->password = $request->login_password;
        $userEloquent->email_verification_send_on = now();
        $userEloquent->role_id = 5;
        $userEloquent->save();
        return $userEloquent;
    }
    public function updateQuickOrgAdmin($organization, $request)
    {
        $userEloquent = UserEloquentModel::find($organization->org_admin_id);
        $userEloquent->first_name = $request->org_admin_name;
        $userEloquent->contact_number = $request->org_admin_contact_number;
        $userEloquent->email = $request->login_email;
        $userEloquent->update();
        return $userEloquent;
    }
}
