<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey;

use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class DeleteSurveyCommand implements CommandInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly int $survey_id
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->delete($this->survey_id);
    }
}
