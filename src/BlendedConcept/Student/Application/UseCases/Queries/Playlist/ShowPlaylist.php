<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Queries\Playlist;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\Student\Domain\Repositories\PlaylistRepositoryInterface;

class ShowPlaylist implements QueryInterface
{
    private PlaylistRepositoryInterface $repository;

    public function __construct(
        private readonly int $id
    ) {
        $this->repository = app()->make(PlaylistRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->showPlaylist($this->id);
    }
}
