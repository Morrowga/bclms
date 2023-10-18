<?php

namespace Src\BlendedConcept\Library\Application\Repositories\Eloquent;

use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Src\BlendedConcept\Library\Domain\Repositories\ResourceRepositoryInterface;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\ResourceEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

class ResourceRepository implements ResourceRepositoryInterface
{

    public function getResources(UserEloquentModel $userEloquentModel)
    {
        $userType = $this->checkUserType($userEloquentModel->id);

        switch ($userType) {
            case 'Organisation Admin':
                $org_admin = OrganisationAdminEloquentModel::where('user_id', $userEloquentModel->id)->first();
                $organisation_id = $org_admin->organisation->id;
                // $organisationEloquent = OrganisationEloquentModel::where('org_admin_id', $org_admin->org_admin_id)->first();

                $mediaItems = MediaEloquentModel::where('collection_name', 'videos')
                    ->with(['organisation', 'teacher'])
                    ->where('organisation_id', $organisation_id)
                    ->where('teacher_id', null)
                    ->where('status', 'active')
                    ->get();

                $mediaItems->each->append('video_url', 'thumb_url');

                return $mediaItems;
                break;

            case 'b2b':
                $teacherEloquent = TeacherEloquentModel::where('user_id', $userEloquentModel->id)->first();

                $mediaItems = MediaEloquentModel::where(function ($query) use ($teacherEloquent, $userEloquentModel) {
                    $query->where('collection_name', 'videos')
                        ->where('organisation_id', $teacherEloquent->organisation_id)
                        ->where(function ($innerQuery) use ($userEloquentModel) {
                            $innerQuery->where('teacher_id', null)
                                ->orWhere('teacher_id', $userEloquentModel->id);
                        })
                        ->whereIn('status', ['active', 'requested']);
                })
                    ->with(['organisation', 'teacher'])
                    ->get();

                $mediaItems->each->append('video_url', 'thumb_url');

                return $mediaItems;

                break;

            case 'b2c':
                $userEloquentModel->getMedia('videos', ['teacher_id' => $userEloquentModel->id]);
                $mediaItems = MediaEloquentModel::where('collection_name', 'videos')
                    ->where('teacher_id', $userEloquentModel->id)
                    ->with(['teacher'])
                    ->get();

                $mediaItems->each->append('video_url', 'thumb_url');

                return $mediaItems;

                break;

            default:
                break;
        }
    }

    public function getResourceStorage(UserEloquentModel $userEloquentModel)
    {
        $userType = $this->checkUserType($userEloquentModel->id);

        switch ($userType) {
            case 'Organisation Admin':
                $org_admin = OrganisationAdminEloquentModel::where('user_id', $userEloquentModel->id)->first();
                if($org_admin->organisation->subscription !== null){
                    $totalStorage = $org_admin->organisation->subscription->b2b_subscription === null ? 0  : $org_admin->organisation->subscription->b2b_subscription->storage_limit;
                } else {
                    $totalStorage = 0;
                }

                $organisation_id = $org_admin->organisation->id;
                $teacherStorages = TeacherEloquentModel::where('organisation_id', $organisation_id)->sum('allocated_storage_limit');

                $usedStorageBytes = MediaEloquentModel::where('collection_name', 'videos')
                    ->where('organisation_id', $organisation_id)
                    ->where('teacher_id', null)
                    ->where('status', 'active')
                    ->sum('size');

                $totalStorageLimit = $totalStorage - $teacherStorages;

                $usedStorage = $usedStorageBytes / 1024 / 1024;

                $leftStorage = $totalStorageLimit - $usedStorage;

                return [
                    "total" => (int) $totalStorage,
                    "used" => $totalStorage == 0 ? 0 : (int) $usedStorage + $teacherStorages,
                    "left" => $totalStorage == 0 ? 0 : $leftStorage
                ];
                break;

            case 'b2b':
                $teacherEloquent = TeacherEloquentModel::where('user_id', $userEloquentModel->id)->first();

                $totalStorage = $teacherEloquent->allocated_storage_limit;

                $usedStorageBytes = MediaEloquentModel::where(function ($query) use ($teacherEloquent, $userEloquentModel) {
                    $query->where('collection_name', 'videos')
                        ->where('organisation_id', $teacherEloquent->organisation_id)
                        ->where('teacher_id', $userEloquentModel->id)
                        ->whereIn('status', ['active', 'requested']);
                })
                ->sum('size');

                $usedStorage = $usedStorageBytes / 1024 / 1024;

                $leftStorage = $totalStorage - $usedStorage;

                return [
                    "total" => (int) $totalStorage,
                    "used" => (int) $usedStorage,
                    "left" => $leftStorage
                ];

                break;

            case 'b2c':
                $teacherEloquent = TeacherEloquentModel::where('user_id', $userEloquentModel->id)->first();
                $totalStorage = $teacherEloquent->subscription == null ? 0 : ($teacherEloquent->subscription->b2c_subscription == null ? 0 : ($teacherEloquent->subscription->b2c_subscription->plan == null ? 0 : $teacherEloquent->subscription->b2c_subscription->plan->storage_limit)); // Retrieve the allocated storage size for the user

                $usedStorageBytes = MediaEloquentModel::where('collection_name', 'videos')
                    ->where('teacher_id', $userEloquentModel->id)
                    ->sum('size');

                $usedStorage = $usedStorageBytes / 1024 / 1024;

                $leftStorage = $totalStorage - $usedStorage;

                return [
                    "total" => (int) $totalStorage,
                    "used" => (int) $usedStorage,
                    "left" => $leftStorage
                ];
                break;

            default:
                break;
        }
    }

    public function getRequestPublishData(UserEloquentModel $userEloquentModel)
    {
        $org_admin = OrganisationAdminEloquentModel::where('user_id', $userEloquentModel->id)->first();
        if ($org_admin) {
            $organisation_id = $org_admin->organisation->id;

            $mediaItems = MediaEloquentModel::where('collection_name', 'videos')
                ->with(['organisation', 'teacher'])
                ->where('organisation_id', $organisation_id)
                ->where('status', 'requested')
                ->get();

            $mediaItems->each->append('video_url', 'thumb_url');

            return $mediaItems;
        } else {
            return [];
        }
    }

    public function createResource(Request $request, UserEloquentModel $userEloquentModel)
    {
        DB::beginTransaction();
        try {
            $userType = $this->checkUserType($userEloquentModel->id);
            switch ($userType) {
                case 'Organisation Admin':

                    $org_admin = OrganisationAdminEloquentModel::where('user_id', $userEloquentModel->id)->first();
                    $organisation_id = $org_admin->organisation->id;
                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->organisation_id = $organisation_id;
                    $media->teacher_id = null; // You may need to set this to an appropriate value if applicable
                    $media->save();
                    break;

                case 'b2b':
                    $teacherEloquent = TeacherEloquentModel::where('user_id', $userEloquentModel->id)->first();

                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->organisation_id = $teacherEloquent->organisation_id;
                    $media->teacher_id = $userEloquentModel->id;
                    $media->save();

                    break;

                case 'b2c':
                    $teacherEloquent = TeacherEloquentModel::where('user_id', $userEloquentModel->id)->first();

                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->teacher_id = $userEloquentModel->id;
                    $media->save();

                    break;
                default:
                    break;
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }
    }


    public function updateResource(Request $request, UserEloquentModel $userEloquentModel, MediaEloquentModel $resource)
    {
        DB::beginTransaction();
        try {
            $userType = $this->checkUserType($userEloquentModel->id);

            switch ($userType) {
                case 'Organisation Admin':
                    $org_admin = OrganisationAdminEloquentModel::where('user_id', $userEloquentModel->id)->first();
                    $organisation_id = $org_admin->organisation->id;
                    if (request()->hasFile('file') && request()->file('file')->isValid()) {
                        if ($resource) {
                            $resource->delete();
                        }
                        $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                        $media->name = $request->filename;
                        $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                        $media->organisation_id = $organisation_id;
                        $media->teacher_id = null; // You may need to set this to an appropriate value if applicable
                        $media->save();
                    }
                    break;

                case 'b2b':
                    $teacherEloquent = TeacherEloquentModel::where('user_id', $userEloquentModel->id)->first();

                    if (request()->hasFile('file') && request()->file('file')->isValid()) {
                        if ($resource) {
                            $resource->delete();
                        }

                        $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                        $media->name = $request->filename;
                        $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                        $media->organisation_id = $teacherEloquent->organisation_id;
                        $media->teacher_id = $userEloquentModel->id;
                        $media->save();
                    }
                    break;

                case 'b2c':
                    $teacherEloquent = TeacherEloquentModel::where('user_id', $userEloquentModel->id)->first();
                    if (request()->hasFile('file') && request()->file('file')->isValid()) {
                        if ($resource) {
                            $resource->delete();
                        }

                        $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                        $media->name = $request->filename;
                        $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                        $media->organisation_id = $teacherEloquent->organisation_id;
                        $media->teacher_id = $userEloquentModel->id;
                        $media->save();
                    }
                    break;
                default:
                    break;
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }
    }

    public function checkUserType($id)
    {
        $org_admin = OrganisationAdminEloquentModel::where('user_id', $id)->first();
        if ($org_admin) {
            $organisation = $org_admin->organisation->id;
        } else {
            $organisation = null;
        }
        if ($organisation) {
            // The user is an organisation admin
            return  'Organisation Admin';
        }

        // If not an organisation admin, check the users table to determine the user type
        $user = UserEloquentModel::find($id);

        if (!$user) {
            // User not found
            return 'User not found';
        }

        $check_b2b = TeacherEloquentModel::where('user_id', $user->id)->first();
        if ($check_b2b && $check_b2b->organisation_id != null) {
            return "b2b";
        }

        $check_b2c = TeacherEloquentModel::where('user_id', $user->id)->first();
        if ($check_b2c && $check_b2c->organisation_id == null) {
            return "b2c";
        }
    }

    public function delete(MediaEloquentModel $resource): void
    {
        $resource->status = 'inactive';
        $resource->save();
    }

    public function requestPublish(MediaEloquentModel $resource)
    {
        $resource->status = 'requested';
        $resource->save();
    }

    public function resourceAction(Request $request)
    {
        $ids = json_decode($request->ids, true);
        $type = $request->type;
        switch ($type) {
            case 'approve':
                MediaEloquentModel::whereIn('id', $ids)->update(['status' => 'active', 'teacher_id' => null]);
                break;
            case 'decline':
                MediaEloquentModel::whereIn('id', $ids)->update(['status' => 'active']);
                break;

            case 'delete':
                MediaEloquentModel::whereIn('id', $ids)->update(['status' => 'inactive']);
                break;
            default:
                break;
        }
    }
}
