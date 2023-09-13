<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\User;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\Common\Domain\CommandInterface;

class ChangeStatusCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request,
        private readonly UserEloquentModel $user,
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        $this->repository->changeStatus($this->request, $this->user);
    }
}
