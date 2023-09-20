<?php

namespace Src\BlendedConcept\Organization\Application\Mappers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Teacher;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class TeacherMapper
{
    public static function fromRequest(Request $request, $teacher_id = null): Teacher
    {
        return new Teacher(
            id : $teacher_id,
            first_name : $request->first_name,
            last_name : $request->last_name,
            email : $request->email,
            role_id : 4,
            contact_number  : $request->contact_number,
            email_verification_send_on : $request->email_verification_send_on,
        );
        // organization_id  : $request->organization_id,
        //     email_verified_at : $request->email_verified_at,
        //     dob : $request->dob,
        //     contact_number  : $request->contact_number,
        //     storage_limit : $request->storage_limit,
        //     password  : $request->password,
        //     is_active : $request->is_active,
        //     stripe_id : $request->stripe_id,
        //     pm_brand : $request->pm_brand,
        //     pm_last_four : $request->pm_last_four,
        //     trial_end_at : $request->trial_end_at,
    }

    public static function toEloquent(Teacher $teacher): UserEloquentModel
    {
        $UserEloquent = new UserEloquentModel();

        if ($teacher->id) {
            $UserEloquent = UserEloquentModel::query()->findOrFail($teacher->id);
        }
        $UserEloquent->first_name = $teacher->first_name;
        $UserEloquent->last_name = $teacher->last_name;
        $UserEloquent->role_id = $teacher->role_id;
        $UserEloquent->email = $teacher->email;
        $UserEloquent->contact_number = $teacher->contact_number;
        $UserEloquent->email_verification_send_on = $teacher->email_verification_send_on;
        $UserEloquent->password = Hash::make('password');

        return $UserEloquent;
    }
}
