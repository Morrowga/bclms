<?php

namespace Src\BlendedConcept\Disability\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Disability\Application\DTO\ThemeData;
use Src\BlendedConcept\Disability\Application\Mappers\ThemeMapper;
use Src\BlendedConcept\Disability\Domain\Model\Entities\Theme;
use Src\BlendedConcept\Disability\Domain\Repositories\ThemeRepositoryInterface;
use Src\BlendedConcept\Disability\Domain\Resources\ThemeResource;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;

class ThemeRepository implements ThemeRepositoryInterface
{
    public function getThemes($filters)
    {

        $themes = ThemeResource::collection(ThemeEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $themes;
    }

    public function createTheme(Theme $theme)
    {
        DB::beginTransaction();
        try {
            $themeEloquent = ThemeMapper::toEloquent($theme);
            $themeEloquent->save();
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    public function updateTheme(ThemeData $themeData)
    {
        DB::beginTransaction();
        try {
            $themeArray = $themeData->toArray();
            $themeEloquent = ThemeEloquentModel::findOrFail($themeData->id);
            $themeEloquent->fill($themeArray);
            $themeEloquent->update();
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    public function deleteTheme(ThemeEloquentModel $theme)
    {
        DB::beginTransaction();
        try {
            $theme->delete();
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }
}
