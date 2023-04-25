<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\User\Domain\Model\Announcement;
use Src\BlendedConcept\User\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\User\Domain\Requests\StoreAnnouncementRequest;
use Src\BlendedConcept\User\Domain\Requests\UpdateAnnouncementRequest;
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

     //store announcement
     public function store(StoreAnnouncementRequest $request)
     {
          $this->authorize('create', Announcement::class);
          $request->validated();
          $this->announcementInterface->createAnnouncement($request);
          return redirect()->route('announcements.index')->with("successMessage", "Announcement created Successfully!");
     }

     //update announcement
     public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
     {
          $this->authorize('edit', Announcement::class);
          $request->validated();
          $this->announcementInterface->updateAnnouncement($request, $announcement);

          return redirect()->route('announcements.index')->with("successMessage", "Announcement updated Successfully!");
     }

     //destroy announcement
     public function destroy(Announcement $announcement)
     {
          $this->authorize('destroy', Announcement::class);
          //   delete permission
          $announcement->delete();
          return  redirect()->route('announcements.index')->with("successMessage", "Announcement deleted Successfully!");
     }
}
