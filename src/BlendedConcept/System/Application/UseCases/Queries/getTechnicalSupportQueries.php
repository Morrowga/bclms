<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\System\Domain\Repositories\TechnicalSupportRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class getTechnicalSupportQueries implements QueryInterface
{
    private TechnicalSupportRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(TechnicalSupportRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getSupportQuestion($this->filters);
    }
}
