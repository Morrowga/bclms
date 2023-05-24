<?php

namespace Src\BlendedConcept\User\Application\UseCases\Queries;

use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetUserList implements QueryInterface
{
    private UserRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(UserRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getUsersNameId();
    }
}
