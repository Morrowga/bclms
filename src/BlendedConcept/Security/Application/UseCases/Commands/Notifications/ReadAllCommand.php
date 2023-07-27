<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\Notifications;

use Src\BlendedConcept\System\Domain\Repositories\NotificationRepositoryInterface;

use Src\Common\Domain\CommandInterface;

class ReadAllCommand implements CommandInterface
{
    private NotificationRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(NotificationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->readAll();
    }
}



