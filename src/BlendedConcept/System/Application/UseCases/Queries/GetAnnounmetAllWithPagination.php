<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;


use Src\Common\Domain\QueryInterface;

use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
class GetAnnounmetAllWithPagination implements QueryInterface
{
    private AnnouncementRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    )
    {
        $this->repository = app()->make(AnnouncementRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getAnnouncements($this->filters);
    }
}
