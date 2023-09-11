<?php

namespace Src\BlendedConcept\System\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Domain\Model\Entities\TechnicalSupport;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\TechnicalSupportEloquentModel;

class TechnicalSupportMapper
{
    public static function fromRequest(Request $request, $support_id = null): TechnicalSupport
    {
        return new TechnicalSupport(

            id : $support_id,
            user_id : $request->user_id,
            date : $request->date,
            has_responsed : $request->has_responsed,
            question : $request->question,
            response : $request->response
        );
    }

    public static function toEloquent(TechnicalSupport $technicalSupport): TechnicalSupportEloquentModel
    {
        $technicalSupportEloquent = new TechnicalSupportEloquentModel();

        if ($technicalSupport->id) {
            $technicalSupportEloquent = technicalSupportEloquentModel::query()->findOrFail($technicalSupport->id);
        }
        $technicalSupportEloquent->user_id = $technicalSupport->user_id;
        $technicalSupportEloquent->date = $technicalSupport->date;
        $technicalSupportEloquent->has_responsed = $technicalSupport->has_responsed;
        $technicalSupportEloquent->question = $technicalSupport->question;
        $technicalSupportEloquent->response = $technicalSupport->response;

        return $technicalSupportEloquent;
    }
}
