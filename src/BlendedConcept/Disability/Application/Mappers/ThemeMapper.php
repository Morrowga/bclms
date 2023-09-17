<?php

namespace Src\BlendedConcept\Disability\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Disability\Domain\Model\Entities\Theme;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;

class ThemeMapper
{
    public static function fromRequest(Request $request, $disability_type_id = null): Theme
    {
        return new Theme(

            id: $disability_type_id,
            name: $request->name,
            description: $request->description
        );
    }

    public static function toEloquent(Theme $Theme): ThemeEloquentModel
    {
        $themeEloquent = new ThemeEloquentModel();

        if ($Theme->id) {
            $themeEloquent = ThemeEloquentModel::query()->findOrFail($Theme->id);
        }
        $themeEloquent->name = $Theme->name;
        $themeEloquent->description = $Theme->description;

        return $themeEloquent;
    }
}
