<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;

class GetUserProfilingSurvey implements QueryInterface
{
    private SurveyRepositoryInterface $repository;

    public function __construct(
    )
    {
        $this->repository = app()->make(SurveyRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getB2CProfilingSurvey();
    }
}
