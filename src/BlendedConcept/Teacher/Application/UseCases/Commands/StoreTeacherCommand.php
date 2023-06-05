<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\User;

use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\BlendedConcept\Security\Domain\Model\User;
use Src\Common\Domain\CommandInterface;


class StoreUserCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly User $user
    )
    {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createUser($this->user);
    }
}
