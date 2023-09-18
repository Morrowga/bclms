<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\Themes;


use Src\BlendedConcept\Disability\Domain\Model\Entities\Theme;
use Src\BlendedConcept\Disability\Domain\Repositories\ThemeRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreThemeCommand implements CommandInterface
{
    private ThemeRepositoryInterface $repository;

    public function __construct(
        private readonly Theme $theme,

    ) {
        $this->repository = app()->make(ThemeRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createTheme($this->theme);
    }
}
