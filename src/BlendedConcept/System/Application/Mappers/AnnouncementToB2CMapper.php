<?php

namespace Src\BlendedConcept\System\Application\Mappers;

use Src\BlendedConcept\System\Domain\Model\Entities\AnnouncementToB2C;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementToB2CEloquentModel;

class AnnouncementToB2CMapper
{
    public static function fromRequest(array $request, $announcement_b2c_id = null): AnnouncementToB2C
    {

        return new AnnouncementToB2C(
            id: $announcement_b2c_id,
            announcement_id: $request['announcement_id'],
            to_b2c_id: $request['to_b2c_id'],
            is_cleared: $request['is_cleared'],
        );
    }

    public static function toEloquent(AnnouncementToB2C $announcementToB2C): AnnouncementToB2CEloquentModel
    {
        $announcementToB2CEloquent = new AnnouncementToB2CEloquentModel();

        if ($announcementToB2C->id) {
            $announcementToB2CEloquent = AnnouncementToB2CEloquentModel::query()->findOrFail($announcementToB2C->id);
        }

        $announcementToB2CEloquent->announcement_id = $announcementToB2C->announcement_id;
        $announcementToB2CEloquent->to_b2c_id = $announcementToB2C->to_b2c_id;
        $announcementToB2CEloquent->is_cleared = $announcementToB2C->is_cleared;

        return $announcementToB2CEloquent;
    }
}
