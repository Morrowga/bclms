<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Src\BlendedConcept\Security\Application\UseCases\Commands\Notifications\ReadAllCommand;
use Src\BlendedConcept\Security\Application\UseCases\Commands\Notifications\ReadCommand;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Notifications\Notification;
use Src\BlendedConcept\System\Domain\Repositories\NotificationRepositoryInterface;
use Src\Common\Infrastructure\Laravel\Controller;

class NotificationController extends Controller
{
    private $notificationInterface;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationInterface = $notificationRepository;
    }

    public function read($id)
    {
        $notificationRead = (new ReadCommand($id));
        $notificationRead->execute();

        return redirect()->back();
    }

    public function readAll()
    {

        $notificationReadAll = (new ReadAllCommand());
        $notificationReadAll->execute();

        return redirect()->back();
    }

    public function getAllNotifications()
    {
        $notifications = (new Notification())->handle();

        return $notifications;
    }
}
