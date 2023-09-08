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
            target_role_id: $request->target_role_id,
            author_id: $request->author_id,
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
        $AnnounmettEloquent->target_role_id = $annoument->target_role_id;
        $AnnounmettEloquent->author_id = $annoument->author_id;

        return $AnnounmettEloquent;
    }
}
