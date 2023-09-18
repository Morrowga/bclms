<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResults;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;

class GetSurveyResults implements QueryInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->GetSurveyResults($this->filters);
    }
}
