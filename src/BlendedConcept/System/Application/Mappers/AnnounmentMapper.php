<?php

namespace Src\BlendedConcept\System\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Domain\Model\Entities\Annoument;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementEloquentModel;

class AnnounmentMapper
{
    public static function fromRequest(Request $request, $announcement_id = null): Annoument
    {

        return new Annoument(
            id: $announcement_id,
            title: $request->title,
            icon: $request->icon,
            message: $request->message,
            by: $request->by,
            to: $request->to,
            org: $request->org,
            users: $request->users,
        );
    }

    public static function toEloquent(Annoument $annoument): AnnouncementEloquentModel
    {
        $AnnounmettEloquent = new AnnouncementEloquentModel();

        if ($annoument->id) {
            $announmettEloquent = AnnouncementEloquentModel::query()->findOrFail($annoument->id);
        }

        $AnnounmettEloquent->title = $annoument->title;
        $AnnounmettEloquent->icon = $annoument->icon;
        $AnnounmettEloquent->message = $annoument->message;
        $AnnounmettEloquent->by = $annoument->by;
        $AnnounmettEloquent->to = $annoument->to;

        return $AnnounmettEloquent;
    }
}
