<?php

namespace Src\BlendedConcept\Disability\Domain\Repositories;

use Src\BlendedConcept\Disability\Application\DTO\ThemeData;
use Src\BlendedConcept\Disability\Domain\Model\Entities\Theme;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;

interface ThemeRepositoryInterface
{
    public function getThemes($filters);

    public function createTheme(Theme $theme);

    public function updateTheme(ThemeData $themeData);

    public function deleteTheme(ThemeEloquentModel $theme);
}
