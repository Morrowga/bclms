<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResults;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyResultRepositoryInterface;

class GetSurveyResponses implements QueryInterface
{
    private SurveyResultRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(SurveyResultRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->GetSurveyResponses($this->filters);
    }
}
