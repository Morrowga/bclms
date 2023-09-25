<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Queries;

use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetUserExperienceSurveyList implements QueryInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getUserExperienceSurveyList($this->filters);
    }
}
