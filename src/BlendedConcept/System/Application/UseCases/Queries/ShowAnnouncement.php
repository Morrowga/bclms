<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\Common\Domain\QueryInterface;

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
