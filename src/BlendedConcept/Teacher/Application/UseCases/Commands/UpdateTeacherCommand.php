<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\User;


use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Security\Application\DTO\UserData;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;

class UpdateUserCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly UserData $userData
    )
    {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateUser($this->userData);
    }
}
