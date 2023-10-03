<?php

namespace Src\BlendedConcept\Library\Application\UseCases\Queries;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Library\Domain\Repositories\ResourceRepositoryInterface;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class GetRequestPublishData implements QueryInterface
{
    private ResourceRepositoryInterface $repository;

    public function __construct(
        private readonly UserEloquentModel $userEloquentModel,

    ) {
        $this->repository = app()->make(ResourceRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getRequestPublishData($this->userEloquentModel);
    }
}
