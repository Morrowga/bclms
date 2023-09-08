<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;

class ShowAnnouncement implements QueryInterface
{
    private AnnouncementRepositoryInterface $repository;

    public function __construct(
        private readonly int $id
    ) {
        $this->repository = app()->make(AnnouncementRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->showAnnouncement($this->id);
    }
}
