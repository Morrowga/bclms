<?php

namespace Src\BlendedConcept\Library\Application\Repositories\Eloquent;

use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Src\BlendedConcept\Library\Domain\Repositories\ResourceRepositoryInterface;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\ResourceEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

class ResourceRepository implements ResourceRepositoryInterface
{

    public function getResources(UserEloquentModel $userEloquentModel){
        $userType = $this->checkUserType($userEloquentModel->id);

        switch ($userType) {
            case 'Organisation Admin':
                $organisationEloquent = OrganisationEloquentModel::where('org_admin_id', $userEloquentModel->id)->first();

                $mediaItems = MediaEloquentModel::where('collection_name', 'videos')
                ->with(['organisation', 'teacher'])
                ->where('organisation_id', $organisationEloquent->id)
                ->get();

                $mediaItems->each->append('video_url', 'thumb_url');

                return $mediaItems;
                break;

            case 'b2b':
                $b2bUserEloquent = TeacherEloquentModel::where('user_id', $userEloquentModel->id)->first();
                $mediaItems = MediaEloquentModel::where('collection_name', 'videos')
                ->where('organisation_id', $b2bUserEloquent->organisation_id)
                ->where('teacher_id', $userEloquentModel->id)
                ->get();

                $mediaItems->each->append('video_url', 'thumb_url');

                return $mediaItems;

                break;

            case 'b2c':
                $userEloquentModel->getMedia('videos', ['teacher_id' => $userEloquentModel->id]);
                $mediaItems = MediaEloquentModel::where('collection_name', 'videos')
                ->where('teacher_id', $userEloquentModel->id)
                ->get();

                $mediaItems->each->append('video_url', 'thumb_url');

                return $mediaItems;

                break;

            default:
                break;
        }

    }

    public function createResource(Request $request, UserEloquentModel $userEloquentModel)
    {
        DB::beginTransaction();
        try {
            $userType = $this->checkUserType($userEloquentModel->id);
            switch ($userType) {
                case 'Organisation Admin':
                    $organisationEloquent = OrganisationEloquentModel::where('org_admin_id', $userEloquentModel->id)->first();
                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->organisation_id = $organisationEloquent->id;
                    $media->teacher_id = null; // You may need to set this to an appropriate value if applicable
                    $media->save();
                    break;

                case 'b2b':
                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->organisation_id = $b2bUserEloquent->organisation_id;
                    $media->teacher_id = $userEloquentModel->id;
                    $media->save();

                    break;

                case 'b2c':
                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->organisation_id = $b2bUserEloquent->organisation_id;
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


    public function updateResource(Request $request, UserEloquentModel $userEloquentModel,MediaEloquentModel $resource)
    {
        DB::beginTransaction();
        try {
            $userType = $this->checkUserType($userEloquentModel->id);
            switch ($userType) {
                case 'Organisation Admin':
                    $organisationEloquent = OrganisationEloquentModel::where('org_admin_id', $userEloquentModel->id)->first();
                    if ($resource) {
                       $resource->delete();
                    }
                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->organisation_id = $organisationEloquent->id;
                    $media->teacher_id = null; // You may need to set this to an appropriate value if applicable
                    $media->save();
                    break;

                case 'b2b':
                    if ($resource) {
                        $resource->delete();
                     }
                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->organisation_id = $b2bUserEloquent->organisation_id;
                    $media->teacher_id = $userEloquentModel->id;
                    $media->save();

                    break;

                case 'b2c':
                    if ($resource) {
                        $resource->delete();
                     }
                    $media = $userEloquentModel->addMedia($request->file)->toMediaCollection('videos', 'media_resource');
                    $media->name = $request->filename;
                    $media->file_name = $request->filename . '.' . $request->file->getClientOriginalExtension();
                    $media->organisation_id = $b2bUserEloquent->organisation_id;
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

    public function checkUserType($id){
        $organisation = OrganisationEloquentModel::where('org_admin_id', $id)->first();

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
        if($check_b2b && $check_b2b->organisation_id != null){
            return "b2b";
        }

        $check_b2c = TeacherEloquentModel::where('user_id', $user->id)->first();
        if($check_b2c && $check_b2c->organisation_id == null){
            return "b2c";
        }
    }

    public function delete(MediaEloquentModel $resource): void
    {
        $resource->delete();
    }
}
