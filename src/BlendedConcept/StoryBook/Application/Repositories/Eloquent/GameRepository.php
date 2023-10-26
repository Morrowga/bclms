<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use ZipArchive;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Support\MediaStream;
use Src\BlendedConcept\StoryBook\Application\DTO\GameData;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Game;
use Src\BlendedConcept\StoryBook\Domain\Resources\GameResource;
use Src\BlendedConcept\StoryBook\Application\Mappers\GameMapper;
use Src\BlendedConcept\StoryBook\Domain\Repositories\GameRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

class GameRepository implements GameRepositoryInterface
{
    //get all games
    public function getGameList($filters)
    {
        $filterItems = json_decode(request('filterItems'));
        if ($filterItems) {
        } else {
            $filterItems = null;
        }
        $games = GameResource::collection(GameEloquentModel::filter($filters)
            ->with(['tags', 'disabilityTypes', 'devices'])
            ->when($filterItems, function ($query, $filterItems) {
                $query->when($filterItems->disability_types, function ($query, $disability) {
                    $query->whereHas('disabilityTypes', function ($query) use ($disability) {
                        $query->whereIn('disability_types.id', $disability);
                    });
                });
                $query->when($filterItems->devices, function ($query, $devices) {
                    $query->whereHas('devices', function ($query) use ($devices) {
                        $query->whereIn('devices.id', $devices);
                    });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10));

        return $games;
    }

    /**
     * Create a new game with the provided game object.
     *
     * @param  Game  $game The game object containing the necessary information.
     * @return void
     */
    public function createGame(Game $game)
    {
        DB::beginTransaction();
        try {
            // Insert data into the game
            $gameEloquent = GameMapper::toEloquent($game);
            $gameEloquent->save();

            // Upload the game's image if provided
            if (request()->hasFile('thumb') && request()->file('thumb')->isValid()) {
                $gameEloquent->addMediaFromRequest('thumb')->toMediaCollection('thumbnail', 'media_game');
            }

            if (request()->hasFile('game') && request()->file('game')->isValid()) {
                $zipFile = request()->file('game');

                // Get the original file name
                $originalFileName = pathinfo($zipFile->getClientOriginalName(), PATHINFO_FILENAME);

                // Define the desired folder name
                $desiredFolderName = $originalFileName . $gameEloquent->id;

                // Create a temporary directory to extract the ZIP contents
                $gameDirectory = public_path('gamefiles/' . $desiredFolderName);
                if (!file_exists($gameDirectory)) {
                    mkdir($gameDirectory, 0755, true);
                }

                // Unzip the file
                $zip = new ZipArchive;
                if ($zip->open($zipFile) === true) {
                    $zip->extractTo($gameDirectory);
                    $zip->close();
                }

                // Check if the 'index.html' file exists in the extracted folder
                $indexPath = $desiredFolderName . '/' . $originalFileName . '/index.html';
                $gameEloquent->game_file = $indexPath;
            }

            if ($gameEloquent->getMedia('thumbnail')->isNotEmpty()) {
                $gameEloquent->thumbnail = $gameEloquent->getMedia('thumbnail')[0]->original_url;
                $gameEloquent->update();
            }


            $tagCollection = collect(request()->tags);
            $disabilityCollection = collect(request()->disability_type_id);
            $deviceCollection = collect(request()->devices);

            $tagLength = $tagCollection->count();
            $disabilityLength = $disabilityCollection->count();
            $deviceLength = $deviceCollection->count();

            if ($tagLength > 0) {
                $gameEloquent->associateTags(request()->tags);
            }

            if ($deviceLength > 0) {
                $gameEloquent->devices()->attach(request()->devices);
            }

            if ($disabilityLength > 0) {
                // Attach disability types with the game
                $gameEloquent->disabilityTypes()->attach(request()->disability_type_id);
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }

    public function download(YourModel $yourModel)
    {
        // Let's get some media.
        $downloads = $yourModel->getMedia('game_file');

        // Download the files associated with the media in a streamed way.
        // No prob if your files are very large.
        return MediaStream::create('my-files.zip')->addMedia($downloads);
    }


    //update game
    public function updateGame(GameData $game)
    {
        DB::beginTransaction();
        try {
            $gameArray = $game->toArray();
            $gameEloquent = GameEloquentModel::query()->find($game->id);
            $gameEloquent->fill($gameArray);
            $gameEloquent->update();

            if (request()->hasFile('thumb') && request()->file('thumb')->isValid()) {
                $old_thumbnail = $gameEloquent->getFirstMedia('thumbnail');
                if ($old_thumbnail != null) {
                    $old_thumbnail->forceDelete();
                }

                $newThumbMedia = $gameEloquent->addMediaFromRequest('thumb')->toMediaCollection('thumbnail', 'media_game');

                if ($newThumbMedia->getUrl()) {
                    $gameEloquent->thumbnail = $newThumbMedia->getUrl();
                    $gameEloquent->update();
                }
            }

            // if (request()->hasFile('game') && request()->file('game')->isValid()) {

            //     $old_game = $gameEloquent->getFirstMedia('game_file');
            //     if ($old_game != null) {
            //         $old_game->forceDelete();
            //     }

            //     $newGameMedia = $gameEloquent->addMediaFromRequest('game')->toMediaCollection('game_file', 'media_game');

            //     if ($newGameMedia->getUrl()) {
            //         $gameEloquent->game_file = $newGameMedia->getUrl();
            //         $gameEloquent->update();
            //     }
            // }

            if (request()->hasFile('game') && request()->file('game')->isValid()) {
                $oldFolderPath = public_path('gamefiles/' . $gameEloquent->game_file);
                if (file_exists($oldFolderPath)) {
                    \File::deleteDirectory($oldFolderPath);
                }
                $zipFile = request()->file('game');

                // Get the original file name
                $originalFileName = pathinfo($zipFile->getClientOriginalName(), PATHINFO_FILENAME);

                // Define the desired folder name
                $desiredFolderName = $originalFileName . $gameEloquent->id;

                // Create a temporary directory to extract the ZIP contents
                $gameDirectory = public_path('gamefiles/' . $desiredFolderName);
                if (!file_exists($gameDirectory)) {
                    mkdir($gameDirectory, 0755, true);
                }

                // Unzip the file
                $zip = new ZipArchive;
                if ($zip->open($zipFile) === true) {
                    $zip->extractTo($gameDirectory);
                    $zip->close();
                }

                // Check if the 'index.html' file exists in the extracted folder
                $indexPath = $desiredFolderName . '/' . $originalFileName . '/index.html';

                $gameEloquent->game_file = $indexPath;
                $gameEloquent->update();
            }

            $tagCollection = collect(request()->tags);
            $disabilityCollection = collect(request()->disability_type_id);
            $deviceCollection = collect(request()->devices);

            $tagLength = $tagCollection->count();
            $disabilityLength = $disabilityCollection->count();
            $deviceLength = $deviceCollection->count();

            if ($tagLength > 0) {
                $gameEloquent->tags()->detach();
                // Attach new tags (assuming $request contains the new tag IDs)
                $gameEloquent->associateTags(request()->tags);
            }

            if ($deviceLength > 0) {
                $gameEloquent->devices()->detach();

                $gameEloquent->devices()->attach(request()->devices);
                // Attach new tags (assuming $request contains the new tag IDs)
            }

            if ($disabilityLength > 0) {
                $gameEloquent->disabilityTypes()->detach();

                $gameEloquent->disabilityTypes()->attach(request()->disability_type_id);
                // Attach new tags (assuming $request contains the new tag IDs)
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();

            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
        }
    }

    public function deleteGame(GameEloquentModel $game)
    {
        $gamePath = public_path('gamefiles/' . $game->game_file);
        if (file_exists($gamePath)) {
            \File::deleteDirectory($gamePath);
        }
        $game->delete();
    }
}
