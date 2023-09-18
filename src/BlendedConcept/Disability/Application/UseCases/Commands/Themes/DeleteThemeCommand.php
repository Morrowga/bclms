<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\Themes;

use Src\BlendedConcept\Disability\Domain\Repositories\ThemeRepositoryInterface;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteThemeCommand implements CommandInterface
{
    private ThemeRepositoryInterface $repository;

    public function __construct(
        private readonly ThemeEloquentModel $theme,

    ) {
        $this->repository = app()->make(ThemeRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteTheme($this->theme);
    }
}
