<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\User;


use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\CommandInterface;
use Illuminate\Http\Request;

class ChangeUserPassword implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly  Request $request
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        $this->repository->changepassword($this->request);
    }
}
