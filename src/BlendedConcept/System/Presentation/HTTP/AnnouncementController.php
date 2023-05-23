<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\System\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\System\Domain\EloquentModels\AnnouncementEloquentModel;
use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\BlendedConcept\System\Domain\Requests\StoreAnnouncementRequest;
use Src\BlendedConcept\System\Domain\Requests\UpdateAnnouncementRequest;
use Src\Common\Infrastructure\Laravel\Controller;


class AnnouncementController extends Controller
{
     private $announcementInterface;
     private $userInterface;
     private $organizationInterface;
     public function __construct(AnnouncementRepositoryInterface $announcementInterface, UserRepositoryInterface $userInterface, OrganizationRepositoryInterface $organizationInterface)
     {
          dd($this->announcementInterface = $announcementInterface);
          $this->userInterface = $userInterface;
          $this->organizationInterface = $organizationInterface;
     }
     //get all announcements
     public function index()
     {
          $this->authorize('view', AnnouncementEloquentModel::class);
          $filters = request()->only(['name', 'search', 'perPage']);
          $users = $this->userInterface->getUsersNameId();
          $organizations = $this->organizationInterface->getOrganizationNameId();
          $announcements = $this->announcementInterface->getAnnouncements($filters);
          return Inertia::render('BlendedConcept/System/Presentation/Resources/Announcements/Index', [
               "announcements" => $announcements,
               "users" => $users,
               "organizations" => $organizations
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
     public function update(UpdateAnnouncementRequest $request, AnnouncementEloquentModel $announcement)
     {
          $this->authorize('edit', Announcement::class);
          $request->validated();
          $this->announcementInterface->updateAnnouncement($request, $announcement);

          return redirect()->route('announcements.index')->with("successMessage", "Announcement updated Successfully!");
     }

     //destroy announcement
     public function destroy(AnnouncementEloquentModel $announcement)
     {
          $this->authorize('destroy', Announcement::class);
          //   delete permission
          $announcement->delete();
          return  redirect()->route('announcements.index')->with("successMessage", "Announcement deleted Successfully!");
     }
}
