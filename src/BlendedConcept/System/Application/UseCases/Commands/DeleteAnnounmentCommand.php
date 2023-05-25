<?php

namespace Src\BlendedConcept\System\Application\UseCases\Commands;


use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
class DeleteAnnounmentCommand implements CommandInterface
{
    private AnnouncementRepositoryInterface $repository;

    public function __construct(
        private readonly int $annoument_id
    )
    {
        $this->repository = app()->make(AnnouncementRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->delete($this->annoument_id);
    }
}
