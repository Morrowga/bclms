<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Commands\Themes;

use Src\BlendedConcept\Disability\Application\DTO\ThemeData;
use Src\BlendedConcept\Disability\Domain\Repositories\ThemeRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateThemeCommand implements CommandInterface
{
    private ThemeRepositoryInterface $repository;

    public function __construct(
        private readonly ThemeData $themeData,

    ) {
        $this->repository = app()->make(ThemeRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateTheme($this->themeData);
    }
}
