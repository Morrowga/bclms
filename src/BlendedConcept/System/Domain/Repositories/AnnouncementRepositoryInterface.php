<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

use Src\BlendedConcept\System\Application\DTO\AnnounmentData;

interface AnnouncementRepositoryInterface
{
    //get all announcements
    public function getAnnouncements($filters);

    //create announcements
    public function createAnnouncement($request);

    //update announcement
    public function updateAnnouncement(AnnounmentData $announment);

    public function delete(int $annountment_id): void;
}
