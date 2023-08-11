<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\Notifications;

use Src\BlendedConcept\System\Domain\Repositories\NotificationRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class ReadCommand implements CommandInterface
{
    private NotificationRepositoryInterface $repository;

    public function __construct(
        private string $notification_id
    ) {
        $this->repository = app()->make(NotificationRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->read($this->notification_id);
    }
}
