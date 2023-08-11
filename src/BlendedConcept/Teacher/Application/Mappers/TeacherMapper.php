<?php

namespace Src\BlendedConcept\Teacher\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Domain\Model\Teacher;

class TeacherMapper
{
    public static function fromRequest(Request $request, $teacher_id = null): Teacher
    {
        return new Teacher(
            id : $teacher_id,
            name : $request->name,
            email : $request->email,
            organization_id  : $request->organization_id,
            email_verified_at : $request->email_verified_at,
            dob : $request->dob,
            contact_number  : $request->contact_number,
            storage_limit : $request->storage_limit,
            password  : $request->password,
            is_active : $request->is_active,
            stripe_id : $request->stripe_id,
            pm_brand : $request->pm_brand,
            pm_last_four : $request->pm_last_four,
            trial_end_at : $request->trial_end_at,
        );
    }

    public static function toEloquent(Teacher $teacher): UserEloquentModel
    {
        $UserEloquent = new UserEloquentModel();

        if ($teacher->id) {
            $UserEloquent = UserEloquentModel::query()->findOrFail($teacher->id);
        }
        $UserEloquent->name = $teacher->name;
        $UserEloquent->email = $teacher->email;
        $UserEloquent->organization_id = auth()->user()->organization_id;
        $UserEloquent->email_verified_at = $teacher->email_verified_at;
        $UserEloquent->dob = $teacher->dob;
        $UserEloquent->contact_number = $teacher->contact_number;
        $UserEloquent->storage_limit = $teacher->storage_limit;
        $UserEloquent->password = $teacher->password;
        $UserEloquent->is_active = $teacher->is_active;
        $UserEloquent->stripe_id = $teacher->stripe_id;
        $UserEloquent->pm_brand = $teacher->pm_brand;
        $UserEloquent->pm_last_four = $teacher->pm_last_four;
        $UserEloquent->trial_end_at = $teacher->trial_end_at;

        return $UserEloquent;
    }
}
