<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResponses;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyResponseRepositoryInterface;

class GetUserSurveyResponses implements QueryInterface
{
    private SurveyResponseRepositoryInterface $repository;

    public function __construct(
        private readonly int $survey_id,
        private readonly int $user_id,
    ) {
        $this->repository = app()->make(SurveyResponseRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->GetUserSurveyResponses($this->survey_id, $this->user_id);
    }
}
