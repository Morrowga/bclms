<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetAnnounmetAllWithPagination implements QueryInterface
{
    private AnnouncementRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(AnnouncementRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getAnnouncements($this->filters);
    }
}
