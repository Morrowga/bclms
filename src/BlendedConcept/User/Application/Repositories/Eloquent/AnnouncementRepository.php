<?php

namespace Src\BlendedConcept\User\Application\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\BlendedConcept\User\Domain\Model\Announcement;
use Src\BlendedConcept\User\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\User\Domain\Resources\AnnouncementResource;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    //get all announcements
    public function getAnnouncements($filters = [])
    {
        $announcements = AnnouncementResource::collection(Announcement::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        return $announcements;
    }

    // create announcement
    public function createAnnouncement($request)
    {
        Announcement::create($request->only(['title', 'message']));
    }

    //update announcement
    public function updateAnnouncement($request, $announcement)
    {
        $announcement->update($request->only(['title', 'message']));
    }
}
