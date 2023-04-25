<?php

namespace Src\BlendedConcept\User\Domain\Repositories;

interface AnnouncementRepositoryInterface
{
    //get all announcements
    public function getAnnouncements();

    //create announcements
    public function createAnnouncement($request);

    //update announcement
    public function updateAnnouncement($request, $announcement);
}
