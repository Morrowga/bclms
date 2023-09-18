<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Question;

use Src\BlendedConcept\Survey\Application\DTO\QuestionData;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateQuestionCommand implements CommandInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly QuestionData $question
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateQuestion($this->question);
    }
}
