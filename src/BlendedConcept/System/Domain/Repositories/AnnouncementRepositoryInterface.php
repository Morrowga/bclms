<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

interface AnnouncementRepositoryInterface
{
    //get all announcements
    public function getAnnouncements($filters);

    //create announcements
    public function createAnnouncement($request);

    //update announcement
    public function updateAnnouncement($request, $announcement);
}
