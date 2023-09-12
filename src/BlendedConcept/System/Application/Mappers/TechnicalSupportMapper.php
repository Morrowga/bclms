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
            has_responded : $request->has_responded,
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
        $technicalSupportEloquent->has_responded = $technicalSupport->has_responded;
        $technicalSupportEloquent->question = $technicalSupport->question;
        $technicalSupportEloquent->response = $technicalSupport->response;

        return $technicalSupportEloquent;
    }
}
