<?php

namespace Src\BlendedConcept\Library\Application\UseCases\Commands;

use Illuminate\Http\Request;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Library\Domain\Repositories\ResourceRepositoryInterface;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class ResourceActionCommand implements CommandInterface
{
    private ResourceRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request,
    ) {
        $this->repository = app()->make(ResourceRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->resourceAction($this->request);
    }
}
