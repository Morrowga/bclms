<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Theme;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\ThemeEloquentModel;

class ThemeMapper
{
    public static function fromRequest(Request $request, $theme_id = null): Theme
    {
        return new Theme(
            id : $theme_id,
            name : $this->name,
            description : $this->description,
        );
    }

    public static function toEloquent(Theme $theme): ThemeEloquentModel
    {
        $themeEloquent = new ThemeEloquentModel();

        if ($theme->id) {
            $themeEloquent = ThemeEloquentModel::query()->findOrFail($theme->id);
        }
        $themeEloquent->id = $theme->id;
        $themeEloquent->name = $theme->name;
        $themeEloquent->description = $theme->description;

        return $themeEloquent;
    }
}
