<?php

namespace Src\BlendedConcept\Library\Application\UseCases\Commands;

use Illuminate\Http\Request;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Library\Domain\Repositories\ResourceRepositoryInterface;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class RequestPublishResourceCommand implements CommandInterface
{
    private ResourceRepositoryInterface $repository;

    public function __construct(
        private readonly MediaEloquentModel $resource,
    ) {
        $this->repository = app()->make(ResourceRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->requestPublish($this->resource);
    }
}
