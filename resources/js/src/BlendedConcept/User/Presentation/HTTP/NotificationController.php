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
          $this->notificationInterface->read($id);
          return redirect()->back();
     }

     public function readAll()
     {
          $this->notificationInterface->readAll();
          return redirect()->back();
     }

     public function getAllNotifications()
     {
          $notifications = $this->notificationInterface->notifications();
          return $notifications;
     }
}
