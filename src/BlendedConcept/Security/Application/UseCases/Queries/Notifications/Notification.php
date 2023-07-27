<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Queries\Notifications;

use Src\BlendedConcept\System\Domain\Repositories\NotificationRepositoryInterface;

use Src\Common\Domain\QueryInterface;

class Notification implements QueryInterface
{
    private NotificationRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(NotificationRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->notifications();
    }
}
