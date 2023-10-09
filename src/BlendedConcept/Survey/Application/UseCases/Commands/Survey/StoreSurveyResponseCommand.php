<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey;

use Illuminate\Http\Request;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyResponseRepositoryInterface;

class StoreSurveyResponseCommand implements CommandInterface
{
    private SurveyResponseRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request
    ) {
        $this->repository = app()->make(SurveyResponseRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createSurveyResponse($this->request);
    }
}
