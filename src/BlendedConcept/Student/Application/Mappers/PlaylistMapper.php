<?php

namespace Src\BlendedConcept\Student\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Student\Domain\Model\Entities\Playlist;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\PlaylistEloquentModel;

class PlaylistMapper
{
    public static function fromRequest(Request $request, $playlist_id = null): Playlist
    {
        return new Playlist(
            id: $playlist_id,
            name: $request->name,
            student_id: $request->student_id,
            teacher_id: auth()->user()->b2bUser->teacher_id,
        );
    }

    public static function toEloquent(Playlist $playlist): PlaylistEloquentModel
    {
        $PlaylistEloquent = new PlaylistEloquentModel();

        if ($playlist->id) {
            $PlaylistEloquent = PlaylistEloquentModel::query()->findOrFail($playlist->id);
        }

        $PlaylistEloquent->student_id = $playlist->student_id;
        $PlaylistEloquent->teacher_id = auth()->user()->b2bUser->teacher_id;
        $PlaylistEloquent->name = $playlist->name;

        return $PlaylistEloquent;
    }
}
