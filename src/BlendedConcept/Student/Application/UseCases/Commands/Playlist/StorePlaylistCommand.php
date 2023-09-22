<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Commands\Playlist;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Student\Domain\Model\Entities\Playlist;
use Src\BlendedConcept\Student\Domain\Repositories\PlaylistRepositoryInterface;

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
