<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\User\Domain\Model\Announcement;
use Src\BlendedConcept\User\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\Common\Infrastructure\Laravel\Controller;


class AnnouncementController extends Controller
{
     private $announcementInterface;

     public function __construct(AnnouncementRepositoryInterface $announcementInterface)
     {
          $this->announcementInterface = $announcementInterface;
     }
     //get all announcements
     public function index()
     {
          $this->authorize('view', Announcement::class);
          $filters = request()->only(['name', 'search', 'perPage']);
          $announcements = $this->announcementInterface->getAnnouncements($filters);
          return Inertia::render('BlendedConcept/User/Presentation/Resources/Announcements/Index', [
               "announcements" => $announcements
          ]);
     }
}
