<?php

namespace Src\BlendedConcept\User\Application\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\BlendedConcept\User\Domain\Model\Announcement;
use Src\BlendedConcept\User\Domain\Repositories\AnnouncementRepositoryInterface;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    //get all announcements
    public function getAnnouncements()
    {
        $announcements = Announcement::all();
        return $announcements;
    }
}
