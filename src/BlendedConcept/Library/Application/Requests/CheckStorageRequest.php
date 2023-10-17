<?php

namespace Src\BlendedConcept\Library\Application\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;

class CheckStorageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'size' => [
                'max:' . $this->checkOrgStorageLimit() // Validate file size against the storage size
            ],
        ];
    }

    public function messages()
    {
        return [
            'size.max' => 'File size exceeds your allocated storage.',
        ];
    }

    public function checkOrgStorageLimit()
    {
        $subscription = auth()->user()->org_admin->organisation->subscription->b2b_subscriptions;
        if ($subscription->isEmpty()) {
            $storageLimit = 1; // Default value when the subscription is empty
        } else {
            $totalStorageLimit = $subscription->first()->storage_limit * 1024;
            $organisation_id = auth()->user()->org_admin->organisation->id;
            // $organisationEloquent = OrganisationEloquentModel::where('org_admin_id', $org_admin->org_admin_id)->first();
            $usedStorage = MediaEloquentModel::where('collection_name', 'videos')
                ->where('organisation_id', $organisation_id)
                ->where('teacher_id', null)
                ->where('status', 'active')
                ->sum('size');

            $usedKilobytes = $usedStorage / 1024;

            $leftStorageLimit = $totalStorageLimit - $usedKilobytes;
        };

        return (int) $leftStorageLimit;
    }
}
