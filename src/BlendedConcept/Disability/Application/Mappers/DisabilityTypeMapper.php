<?php

namespace Src\BlendedConcept\Disability\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Disability\Domain\Model\DisabilityType;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;

class DisabilityTypeMapper
{
    public static function fromRequest(Request $request, $disability_type_id = null): DisabilityType
    {
        return new DisabilityType(

            id: $disability_type_id,
            name: $request->name,
            description: $request->description
        );
    }

    public static function toEloquent(DisabilityType $disabilityType): DisabilityTypeEloquentModel
    {
        $DisabilityTypeEloquent = new DisabilityTypeEloquentModel();

        if ($disabilityType->id) {
            $DisabilityTypeEloquent = DisabilityTypeEloquentModel::query()->findOrFail($disabilityType->id);
        }
        $DisabilityTypeEloquent->name = $disabilityType->name;
        $DisabilityTypeEloquent->description = $disabilityType->description;

        return $DisabilityTypeEloquent;
    }
}
