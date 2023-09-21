<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Queries\Playlist;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Student\Domain\Repositories\PlaylistRepositoryInterface;

class GetPlaylist implements QueryInterface
{
    private PlaylistRepositoryInterface $repository;

    public function __construct(
        private readonly array $filters
    ) {
        $this->repository = app()->make(PlaylistRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getPlaylist($this->filters);
    }
}
