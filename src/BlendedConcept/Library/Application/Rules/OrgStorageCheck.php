<?php

namespace Src\BlendedConcept\Library\Application\Rules;

use Illuminate\Contracts\Validation\Rule;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

class OrgStorageCheck implements Rule
{
    public function passes($attribute, $value)
    {
        // Implement your custom logic to check if the file size is within the organization's storage limit.
        $orgStorageLimit = $this->checkOrgStorageLimit(); // Replace this with your actual logic.
        return $value <= $orgStorageLimit;
    }

    public function message()
    {
        return 'The file size exceeds the organization\'s storage limit.';
    }

    public function checkOrgStorageLimit()
    {
        $subscription = auth()->user()->org_admin->organisation->subscription->b2b_subscription;
        if ($subscription === null) {
            $leftStorageLimit = 1; // Default value when the subscription is empty
        } else {
            $totalStorage = $subscription->storage_limit * 1024;
            $organisation_id = auth()->user()->org_admin->organisation->id;
            $teacherStorages = TeacherEloquentModel::where('organisation_id', $organisation_id)->sum('allocated_storage_limit');
            // $organisationEloquent = OrganisationEloquentModel::where('org_admin_id', $org_admin->org_admin_id)->first();
            $usedStorage = MediaEloquentModel::where('collection_name', 'videos')
                ->where('organisation_id', $organisation_id)
                ->where('teacher_id', null)
                ->where('status', 'active')
                ->sum('size');

            $teacherStorageKiloBytes = $teacherStorages * 1024;

            $totalStorageLimit = $totalStorage - $teacherStorageKiloBytes;
            $usedKilobytes = $usedStorage / 1024;

            $leftStorageLimit = $totalStorageLimit - $usedKilobytes;
        };

        return (int) $leftStorageLimit;
    }
}
