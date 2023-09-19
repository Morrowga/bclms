<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Queries;

use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class ShowSurvey implements QueryInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly int $id
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->showSurvey($this->id);
    }
}