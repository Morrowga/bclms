<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Survey\Application\DTO\SurveyData;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;

class UpdateSurveyCommand implements CommandInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly SurveyData $survey
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateSurvey($this->survey);
    }
}
