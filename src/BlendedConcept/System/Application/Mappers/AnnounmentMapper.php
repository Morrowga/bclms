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
        $companyEloquent->fiscal_name = $company->fiscal_name;
        $companyEloquent->social_name = $company->social_name;
        $companyEloquent->vat = $company->vat;
        $companyEloquent->is_active = $company->is_active;
        return $companyEloquent;
    }
}
