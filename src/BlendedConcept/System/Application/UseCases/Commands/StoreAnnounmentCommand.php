<?php

namespace Src\BlendedConcept\System\Application\UseCases\Commands;

use Src\BlendedConcept\System\Domain\Model\Entities\Annoument;
use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StoreAnnounmentCommand implements CommandInterface
{
    private AnnouncementRepositoryInterface $repository;

    public function __construct(
        private readonly Annoument $annoument
    ) {
        $this->repository = app()->make(AnnouncementRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createAnnouncement($this->annoument);
    }
}
