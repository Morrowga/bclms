<?php

namespace Src\BlendedConcept\System\Domain\Services;

use Src\BlendedConcept\System\Application\DTO\AnnounmentData;
use Src\BlendedConcept\System\Application\Mappers\AnnounmentMapper;
use Src\BlendedConcept\System\Application\Requests\StoreAnnouncementRequest;
use Src\BlendedConcept\System\Application\Requests\UpdateAnnouncementRequest;
use Src\BlendedConcept\System\Application\UseCases\Commands\DeleteAnnounmentCommand;
use Src\BlendedConcept\System\Application\UseCases\Commands\StoreAnnounmentCommand;
use Src\BlendedConcept\System\Application\UseCases\Commands\UpdateAnnounmentCommand;

class AnnounmnetService
{
    public function createAnnoument(StoreAnnouncementRequest $request)
    {
        $request->validated();
        //Creates a new announcement object from the request data.
        $newAnnoument = AnnounmentMapper::fromRequest($request);
        // Creates a new StoreAnnounmentCommand object and executes it.
        $storeAnnounmentCommand = new StoreAnnounmentCommand($newAnnoument);
        $storeAnnounmentCommand->execute();
    }

    public function updateAnnounment(UpdateAnnouncementRequest $request, $announcement_id)
    {
        $announcement = AnnounmentData::fromRequest($request, $announcement_id);
        $updateAnnounmentCommand = (new UpdateAnnounmentCommand($announcement));
        $updateAnnounmentCommand->execute();
    }

    public function deleteAnnounment($announcement_id)
    {
        $announment = new DeleteAnnounmentCommand($announcement_id);
        $announment->execute();
    }
}
