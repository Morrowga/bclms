<?php

namespace Src\BlendedConcept\System\Application\Mappers;

use Src\BlendedConcept\System\Domain\Model\Entities\AnnouncementToBcStaff;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementToBcStaffEloquentModel;

class AnnouncementToBcStaffMapper
{
    public static function fromRequest(array $request, $announcement_bc_staff_id = null): AnnouncementToBcStaff
    {

        return new AnnouncementToBcStaff(
            id: $announcement_bc_staff_id,
            announcement_id: $request['announcement_id'],
            to_bc_staff_user_id: $request['to_bc_staff_user_id'],
            is_cleared: $request['is_cleared'],
        );
    }

    public static function toEloquent(AnnouncementToBcStaff $announcementToBcStaff): AnnouncementToBcStaffEloquentModel
    {
        $announcementToBcStaffEloquent = new AnnouncementToBcStaffEloquentModel();

        if ($announcementToBcStaff->id) {
            $announcementToBcStaffEloquent = AnnouncementToBcStaffEloquentModel::query()->findOrFail($announcementToBcStaff->id);
        }

        $announcementToBcStaffEloquent->announcement_id = $announcementToBcStaff->announcement_id;
        $announcementToBcStaffEloquent->to_bc_staff_user_id = $announcementToBcStaff->to_bc_staff_user_id;
        $announcementToBcStaffEloquent->is_cleared = $announcementToBcStaff->is_cleared;

        return $announcementToBcStaffEloquent;
    }
}
