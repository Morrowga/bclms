<?php

namespace Src\BlendedConcept\Library\Application\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;

class StoreResourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if(auth()->user()->role->name == 'Teacher') {
            return [
                'filename' => [
                    'required',
                ],
                'file' => [
                    'required',
                    'file',
                    'max:' . $this->checkTeacherStorageLimit(), // Validate file size against the allocated storage size
                ],
            ];
        }

        return [
            'filename' => [
                'required',
            ],
            'file' => [
                'required',
                'file',
                'max:' . $this->checkOrgStorageLimit() // Validate file size against the storage size
            ],
        ];


    }

    public function messages()
    {
        return [
            'filename' => 'Filename is required',
            'file' => 'File is required',
            'file.max' => 'File size exceeds your allocated storage.',
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

    public function checkTeacherStorageLimit(){
        $allocatedStorage = auth()->user()->b2bUser->allocated_storage_limit === null ?  0 : (int) auth()->user()->b2bUser->allocated_storage_limit * 1024; // Retrieve the allocated storage size for the user
        $teacherEloquent = auth()->user()->b2bUser;
        $userEloquentModel = auth()->user();
        if($allocatedStorage > 0) {
            $usedStorage = MediaEloquentModel::where(function ($query) use ($teacherEloquent, $userEloquentModel) {
                $query->where('collection_name', 'videos')
                    ->where('organisation_id', $teacherEloquent->organisation_id)
                    ->where(function ($innerQuery) use ($userEloquentModel) {
                        $innerQuery->where('teacher_id', $userEloquentModel->id);
                    })
                    ->whereIn('status', ['active', 'requested']);
                })
                ->sum('size');

            if($usedStorage > 0) {
                $usedKilobytes = $usedStorage / 1024;

                $leftStorageLimit = $allocatedStorage - $usedKilobytes;

                return (int) $leftStorageLimit;
            }
            return (int) $allocatedStorage;
        }

        return 1;
    }
}
