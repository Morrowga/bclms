<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\System\Application\DTO\AnnounmentData;
use Src\BlendedConcept\System\Application\Mappers\AnnounmentMapper;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;
use Src\BlendedConcept\System\Domain\Resources\AnnouncementResource;
use Src\BlendedConcept\System\Application\Mappers\AnnouncementToB2BMapper;
use Src\BlendedConcept\System\Application\Mappers\AnnouncementToB2CMapper;
use Src\BlendedConcept\System\Application\Mappers\AnnouncementToBcStaffMapper;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2cUserEloquentModel;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    //get all announcements
    public function getAnnouncements($filters = [])
    {
        $announcements = AnnouncementResource::collection(AnnouncementEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $announcements;
    }

    // create announcement
    public function createAnnouncement($request)
    {
        DB::beginTransaction();

        try {
            $announmentEloquent = AnnounmentMapper::toEloquent($request);
            $announmentEloquent->save();

            $announcement_id = $announmentEloquent->id;

            $orgArray = json_decode($request->org, true);
            $userArray = json_decode($request->users, true);

            if ($orgArray > 0) {
                foreach ($orgArray as $orgId) {
                    $orgAdmin = B2bUserEloquentModel::where('user_id', $orgId)->first();
                    // if(!empty($orgAdmin)){
                        $requestContent = [
                            'announcement_id' => (int) $announcement_id, // Ensure announcement_id is an integer
                            'to_b2b_id' => (int) $orgAdmin->b2b_user_id, // Ensure to_b2b_id is an integer
                            'is_cleared' => true,
                        ];

                        $announcementToB2B = AnnouncementToB2BMapper::fromRequest($requestContent);

                        $announmentB2BEloquent = AnnouncementToB2BMapper::toEloquent($announcementToB2B);
                        $announmentB2BEloquent->save();

                        $orgAdmin->users->notify(new BcNotification(['message' => $request->title, 'from' => $request->by, 'to' => $orgAdmin->users->full_name, 'type' => $request->type ?? '']));
                    // }
                }
            }
            if ($userArray > 0) {
                foreach ($userArray as $userId) {
                    $userType = $this->checkUserType($userId);
                    if ($userType['type'] == 'b2c') {
                        $requestContent = [
                            'announcement_id' => (int) $announcement_id,
                            'to_b2c_id' => (int) $userType['id'],
                            'is_cleared' => true,
                        ];
                        $announmentToB2C = AnnouncementToB2CMapper::fromRequest($requestContent);

                        $announmentB2CEloquent = AnnouncementToB2CMapper::toEloquent($announmentToB2C);
                        $announmentB2CEloquent->save();

                        $receiver = UserEloquentModel::find($userId);
                        $receiver->notify(new BcNotification(['message' => $request->title, 'from' => $request->by, 'to' => $receiver->full_name, 'type' => $request->type ?? '']));
                    } elseif ($userType['type'] == 'b2b') {
                        $requestContent = [
                            'announcement_id' => (int) $announcement_id, // Ensure announcement_id is an integer
                            'to_b2b_id' => (int) $userType['id'],                 // Ensure to_b2b_id is an integer
                            'is_cleared' => true,
                        ];
                        $announcementToB2B = AnnouncementToB2BMapper::fromRequest($requestContent);

                        $announmentB2BEloquent = AnnouncementToB2BMapper::toEloquent($announcementToB2B);
                        $announmentB2BEloquent->save();

                        $receiver = UserEloquentModel::find($userId);
                        $receiver->notify(new BcNotification(['message' => $request->title, 'from' => $request->by, 'to' => $receiver->full_name, 'type' => $request->type ?? '']));
                    } elseif ($userType['type'] == 'bcstaff') {
                        $requestContent = [
                            'announcement_id' => (int) $announcement_id, // Ensure announcement_id is an integer
                            'to_bc_staff_user_id' => (int) $userType['id'],                 // Ensure to_b2b_id is an integer
                            'is_cleared' => true,
                        ];
                        $announcementToBcStaff = AnnouncementToBcStaffMapper::fromRequest($requestContent);

                        $announcementToBcStaffEloquent = AnnouncementToBcStaffMapper::toEloquent($announcementToBcStaff);
                        $announcementToBcStaffEloquent->save();

                        $receiver = UserEloquentModel::find($userId);
                        $receiver->notify(new BcNotification(['message' => $request->title, 'from' => $request->by, 'to' => $receiver->full_name, 'type' => $request->type ?? '']));
                    }
                }
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

    }

    //check user type
    private function checkUserType($id)
    {
        $b2c = B2cUserEloquentModel::where('user_id', $id)->with('users')->first();
        if (! empty($b2c)) {
            return [
                'type' => 'b2c',
                'id' => $b2c->b2c_user_id,
            ]; // b2c type
        }

        $b2b = B2bUserEloquentModel::where('user_id', $id)->with('users')->first();
        if (! empty($b2b)) {
            return [
                'type' => 'b2b',
                'id' => $b2b->b2b_user_id,
            ]; // b2b type
        }

        $bcstaff = UserEloquentModel::find($id);
        if (! empty($bcstaff)) {
            return [
                'type' => 'bcstaff',
                'id' => $bcstaff->id,
            ]; // bcstaff type

            return 3; // bcstaff type
        }

        return null; // Unknown type
    }

    public function showAnnouncement($id)
    {
        $announcement = new AnnouncementResource(AnnouncementEloquentModel::where('id', $id)->first());

        return $announcement;
    }

    //update announcement
    public function updateAnnouncement(AnnounmentData $annountment)
    {
        // $announcementArray = $annountment->toArray();
        // $announemtEloquent = AnnouncementEloquentModel::query()->with(['announcement_to_b2c_user', 'announcement_to_b2b_user', 'announcement_to_bcstaff_user'])->find($annountment->id);
        // $create_by_user = OrganizationEloquentModel::find($annountment->to);
        // // $receive_user = UserEloquentModel::find($annountment->by);
        // $announemtEloquent->fill($announcementArray);
        // $announemtEloquent->save();

        // foreach ($announemtEloquent->announcement_to_b2c_user as $b2cUser) {
        //     $b2cEloquent = B2cUserEloquentModel::where('b2c_user_id', $b2cUser->to_b2c_id)->with('users')->first();
        //     if (! empty($b2cEloquent)) {
        //         $b2cEloquent->users->notify(new BcNotification(['message' => $annountment->title, 'from' => $announcement->to, 'to' => $b2cEloquent->users->full_name, 'type' => $annountment->type ?? '']));
        //     }
        // }
        // foreach ($announemtEloquent->announcement_to_b2b_user as $b2bUser) {
        //     $b2bEloquent = B2bUserEloquentModel::where('b2b_user_id', $b2bUser->to_b2b_id)->with('users')->first();
        //     if (! empty($b2bEloquent)) {
        //         $b2bEloquent->users->notify(new BcNotification(['message' => $annountment->title, 'from' => $announcement->to, 'to' => $b2bEloquent->users->full_name, 'type' => $annountment->type ?? '']));
        //     }
        // }
        // foreach ($announemtEloquent->announcement_to_bcstaff_user as $bcStaff) {
        //     $bcStaffEloquent = UserEloquentModel::find($bcStaff->to_bc_staff_id);
        //     if (! empty($bcStaffEloquent)) {
        //         $bcStaffEloquent->notify(new BcNotification(['message' => $annountment->title, 'from' => $announcement->to, 'to' => $bcStaffEloquent->full_name, 'type' => $annountment->type ?? '']));
        //     }
        // }
    }

    public function delete(int $annountment_id): void
    {
        $annount = AnnouncementEloquentModel::query()->findOrFail($annountment_id);
        $annount->delete();
    }
}
