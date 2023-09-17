<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Survey\Domain\Model\Survey;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;

class StoreSurveyCommand implements CommandInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly Survey $survey
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createSurvey($this->survey);
    }
}
