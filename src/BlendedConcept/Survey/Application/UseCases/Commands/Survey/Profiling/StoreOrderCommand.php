<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey\Profiling;

use Illuminate\Http\Request;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;

class StoreOrderCommand implements CommandInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request,
        private readonly SurveyEloquentModel $survey
    ) {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->storeOrder($this->request, $this->survey);
    }
}
