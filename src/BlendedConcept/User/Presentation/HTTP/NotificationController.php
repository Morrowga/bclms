<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;

use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\User\Domain\Repositories\NotificationRepositoryInterface;

class NotificationController extends Controller
{
    private $notificationInterface;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationInterface = $notificationRepository;
    }

   public function read($id)
   {
        return $this->notificationInterface->read($id);
   }

   public function readAll()
   {
        return $this->notificationInterface->readAll();
   }
}
