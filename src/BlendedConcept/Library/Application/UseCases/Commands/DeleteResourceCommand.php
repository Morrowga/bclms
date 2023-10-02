<?php

namespace Src\BlendedConcept\Library\Application\UseCases\Commands;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Library\Domain\Repositories\ResourceRepositoryInterface;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;

class DeleteResourceCommand implements CommandInterface
{
    private ResourceRepositoryInterface $repository;

    public function __construct(
        private readonly  MediaEloquentModel $resource
    ) {
        $this->repository = app()->make(ResourceRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->delete($this->resource);
    }
}
