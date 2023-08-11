<?php

namespace Src\BlendedConcept\System\Application\UseCases\Commands;

use Src\BlendedConcept\System\Application\DTO\AnnounmentData;
use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateAnnounmentCommand implements CommandInterface
{
    private AnnouncementRepositoryInterface $repository;

    public function __construct(
        private readonly AnnounmentData $annoument
    ) {
        $this->repository = app()->make(AnnouncementRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateAnnouncement($this->annoument);
    }
}
