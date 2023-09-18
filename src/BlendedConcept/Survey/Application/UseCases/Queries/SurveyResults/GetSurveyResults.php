<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResults;

use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\Common\Domain\QueryInterface;

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
