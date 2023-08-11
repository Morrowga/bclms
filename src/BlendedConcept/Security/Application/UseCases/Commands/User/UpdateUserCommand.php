<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\User;

use Src\BlendedConcept\Security\Application\DTO\UserData;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateUserCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly UserData $userData
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateUser($this->userData);
    }
}
