<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Student\Application\DTO\PlaylistData;
use Src\BlendedConcept\Student\Application\Mappers\PlaylistMapper;
use Src\BlendedConcept\Student\Application\Requests\StorePlaylistRequest;
use Src\BlendedConcept\Student\Application\Requests\UpdatePlaylistRequest;
use Src\BlendedConcept\Student\Application\UseCases\Commands\Playlist\DeletePlaylistCommand;
use Src\BlendedConcept\Student\Application\UseCases\Commands\Playlist\StorePlaylistCommand;
use Src\BlendedConcept\Student\Application\UseCases\Commands\Playlist\UpdatePlaylistCommand;
use Src\BlendedConcept\Student\Application\UseCases\Queries\Playlist\GetPlaylist;
use Src\BlendedConcept\Student\Application\UseCases\Queries\Playlist\ShowPlaylist;
use Src\BlendedConcept\Student\Application\Policies\PlaylistPolicy;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\PlaylistEloquentModel;
use Symfony\Component\HttpFoundation\Response;

class PlayListController
{
    public function index()
    {
        abort_if(authorize('view', PlaylistPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $filters = request(['search', 'name']) ?? [];

            $playlists = (new GetPlaylist($filters))->handle();

            return Inertia::render(config('route.playlist.index'), [
                'playlists' => $playlists,
            ]);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('playlists.index')->with('errorMessage', $e->getMessage());
        }
    }

    public function create()
    {
        abort_if(authorize('create', PlaylistPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render(config('route.playlist.create'));
    }

    /**
     * This function stores a new playlist.
     *
     * @param  StoreTeacherRequest  $request The request object
     * @return \Illuminate\Http\RedirectResponse The redirect response
     */
    public function store(StorePlaylistRequest $request)
    {
        abort_if(authorize('store', PlaylistPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $request->validated();
            //Creates a new playlist object from the request data.
            $newPlaylist = PlaylistMapper::fromRequest($request);

            // Creates a new StorePlaylistCommand object and executes it.
            $storePlaylistCommand = new StorePlaylistCommand($newPlaylist);
            $storePlaylistCommand->execute();
        } catch (\Exception $e) {

            // Handle the exception here
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }

        /**
         * Returns a redirect response to the playlist index page.
         */
        return redirect()->route('playlists.index')->with('successMessage', 'Playlist created Successfully!');
    }

    public function edit($id)
    {
        abort_if(authorize('edit', PlaylistPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $playlist = (new ShowPlaylist($id))->handle();

        return Inertia::render(config('route.playlist.edit'), [
            'playlist' => $playlist,
        ]);
    }

    /**
     * Update an playlist.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePlaylistRequest $request, PlaylistEloquentModel $playlist)
    {
        abort_if(authorize('update', PlaylistPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Validate the request.
         */
        $request->validated();
        /**
         * Try to update the playlist.
         */
        try {
            $playlistData = PlaylistData::fromRequest($request, $playlist->id);
            $updatePlaylistCommand = (new UpdatePlaylistCommand($playlistData));
            $updatePlaylistCommand->execute();

            return redirect()->route('playlists.index')->with('successMessage', 'Playlist updated Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function show($id)
    {
        abort_if(authorize('show', PlaylistPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $playlist = (new ShowPlaylist($id))->handle();

        return Inertia::render(config('route.playlist.show'), [
            'playlist' => $playlist,
        ]);
    }

    /**
     * Delete an playlist.
     *
     * @param  UserEloquentModel  $playlist The playlist to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PlaylistEloquentModel $playlist)
    {
        abort_if(authorize('destroy', PlaylistPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Try to delete the playlist.
         */
        try {
            $playDestroy = new DeletePlaylistCommand($playlist->id);
            $playDestroy->execute();

            return redirect()->route('playlists.index')->with('successMessage', 'Playlist deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}
