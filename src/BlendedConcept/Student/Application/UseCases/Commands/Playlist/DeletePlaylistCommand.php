<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Commands\Playlist;

use Src\BlendedConcept\Student\Domain\Repositories\PlaylistRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class DeletePlaylistCommand implements CommandInterface
{
    private PlaylistRepositoryInterface $repository;

    public function __construct(
        private readonly int $playlist_id
    ) {
        $this->repository = app()->make(PlaylistRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->delete($this->playlist_id);
    }
}
