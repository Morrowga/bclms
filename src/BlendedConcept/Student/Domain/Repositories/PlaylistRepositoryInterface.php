<?php

namespace Src\BlendedConcept\Student\Domain\Repositories;

use Src\BlendedConcept\Student\Application\DTO\PlaylistData;
use Src\BlendedConcept\Student\Domain\Model\Entities\Playlist;

interface PlaylistRepositoryInterface
{
    public function getPlaylist($filters = []);

    public function showPlaylist($id);

    public function createPlaylist(Playlist $student);

    public function updatePlaylist(PlaylistData $playlistData);

    public function delete(int $playlist_id);

    public function getStorybooksForPlaylist($filters);
}
