<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;

class GetUserSurveyByRole implements QueryInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
        private readonly String $appear_on,
    )
    {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getSurveyByRole($this->appear_on);
    }
}
