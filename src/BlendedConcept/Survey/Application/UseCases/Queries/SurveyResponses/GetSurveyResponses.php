<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResponses;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyResponseRepositoryInterface;

class GetSurveyResponses implements QueryInterface
{
    private SurveyResponseRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(SurveyResponseRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->GetSurveyResponses($this->filters);
    }
}
