<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Question;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;

class DeleteQuestionCommand implements CommandInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly int $question_id
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteQuestion($this->question_id);
    }
}
