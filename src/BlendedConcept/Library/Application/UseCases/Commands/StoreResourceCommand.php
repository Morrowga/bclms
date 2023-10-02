<?php

namespace Src\BlendedConcept\Library\Application\UseCases\Commands;

use Illuminate\Http\Request;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Library\Domain\Repositories\ResourceRepositoryInterface;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class StoreResourceCommand implements CommandInterface
{
    private ResourceRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request,
        private readonly UserEloquentModel $userEloquentModel,
    ) {
        $this->repository = app()->make(ResourceRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createResource($this->request, $this->userEloquentModel);
    }
}
