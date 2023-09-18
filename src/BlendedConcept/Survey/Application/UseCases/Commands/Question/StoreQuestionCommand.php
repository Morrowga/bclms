<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Question;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Survey\Domain\Model\Entities\Question;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Illuminate\Http\Request;

class StoreQuestionCommand implements CommandInterface
{
private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createQuestion($this->request);
    }
}
