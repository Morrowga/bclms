<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\User;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class ChangeUserPassword implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        $this->repository->changepassword($this->request);
    }
}
