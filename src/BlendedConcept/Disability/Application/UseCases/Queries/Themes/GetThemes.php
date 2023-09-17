<?php

namespace Src\BlendedConcept\Disability\Application\UseCases\Queries\Themes;

use Src\BlendedConcept\Disability\Domain\Repositories\ThemeRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetThemes implements QueryInterface
{
    private ThemeRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(ThemeRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getThemes($this->filters);
    }
}
