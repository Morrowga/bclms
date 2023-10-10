<?php

namespace Src\BlendedConcept\Survey\Application\UseCases\Commands\Response;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyResponseRepositoryInterface;

class DeleteResponseCommand implements CommandInterface
{
    private SurveyResponseRepositoryInterface $repository;

    public function __construct(
        private readonly int $response_id
    ) {
        $this->repository = app()->make(SurveyResponseRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteResponse($this->response_id);
    }
}
