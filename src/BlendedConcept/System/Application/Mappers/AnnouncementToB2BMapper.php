<?php

namespace Src\BlendedConcept\System\Application\Mappers;

use Src\BlendedConcept\System\Domain\Model\Entities\AnnouncementToB2B;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementToB2BEloquentModel;

class AnnouncementToB2BMapper
{
    public static function fromRequest(array $request, $announcement_b2b_id = null): AnnouncementToB2B
    {

        return new AnnouncementToB2B(
            id: $announcement_b2b_id,
            announcement_id: $request['announcement_id'],
            to_b2b_id: $request['to_b2b_id'],
            is_cleared: $request['is_cleared'],
        );
    }

    public static function toEloquent(AnnouncementToB2B $announcementToB2B): AnnouncementToB2BEloquentModel
    {
        $announcementToB2BEloquent = new AnnouncementToB2BEloquentModel();

        if ($announcementToB2B->id) {
            $announcementToB2BEloquent = AnnouncementToB2BEloquentModel::query()->findOrFail($announcementToB2B->id);
        }

        $announcementToB2BEloquent->announcement_id = $announcementToB2B->announcement_id;
        $announcementToB2BEloquent->to_b2b_id = $announcementToB2B->to_b2b_id;
        $announcementToB2BEloquent->is_cleared = $announcementToB2B->is_cleared;

        return $announcementToB2BEloquent;
    }
}
