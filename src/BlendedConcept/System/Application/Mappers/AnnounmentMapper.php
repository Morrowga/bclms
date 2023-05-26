<?php

namespace Src\BlendedConcept\System\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Domain\Model\Annoument;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementEloquentModel;

class AnnounmentMapper
{
    public static function fromRequest(Request $request, $announcement_id = null): Annoument
    {

        return new Annoument(
            id: $announcement_id,
            title: $request->title,
            message: $request->message,
            created_by: $request->created_by,
            trigger_on: $request->trigger_on,
            send_to: $request->send_to,
        );
    }

    public static function fromEloquent(): Annoument
    {


    }

    public static function toEloquent(Annoument $annoument): AnnouncementEloquentModel
    {
        $AnnounmettEloquent = new AnnouncementEloquentModel();

        if ($annoument->id) {
            $announmettEloquent = AnnouncementEloquentModel::query()->findOrFail($annoument->id);
        }

        $AnnounmettEloquent->title = $annoument->title;
        $AnnounmettEloquent->message = $annoument->message;
        $AnnounmettEloquent->created_by = $annoument->created_by;
        $AnnounmettEloquent->trigger_on = $annoument->trigger_on;
        $AnnounmettEloquent->send_to = $annoument->send_to;

        return $AnnounmettEloquent;
    }
}
