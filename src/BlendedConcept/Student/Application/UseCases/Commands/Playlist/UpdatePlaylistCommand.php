<?php

namespace Src\BlendedConcept\Student\Application\UseCases\Commands\Playlist;

use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\Student\Application\DTO\PlaylistData;
use Src\BlendedConcept\Student\Domain\Repositories\PlaylistRepositoryInterface;

class UpdatePlaylistCommand implements CommandInterface
{
    private PlaylistRepositoryInterface $repository;

    public function __construct(
        private readonly PlaylistData $playlist
    ) {
        $this->repository = app()->make(PlaylistRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updatePlaylist($this->playlist);
    }
}
