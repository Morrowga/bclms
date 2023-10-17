<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Queries\Playlist;

use Src\BlendedConcept\Student\Domain\Repositories\PlaylistRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStorybooksForPlaylist implements QueryInterface
{
    private PlaylistRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(PlaylistRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStorybooksForPlaylist($this->filters);
    }
}
