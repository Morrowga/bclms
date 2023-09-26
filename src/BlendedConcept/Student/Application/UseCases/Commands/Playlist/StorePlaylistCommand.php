<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Commands\Playlist;

use Src\BlendedConcept\Student\Domain\Model\Entities\Playlist;
use Src\BlendedConcept\Student\Domain\Repositories\PlaylistRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class StorePlaylistCommand implements CommandInterface
{
    private PlaylistRepositoryInterface $repository;

    public function __construct(
        private readonly Playlist $playlist
    ) {
        $this->repository = app()->make(PlaylistRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->createPlaylist($this->playlist);
    }
}
