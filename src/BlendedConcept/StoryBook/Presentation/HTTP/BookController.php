<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookData;
use Src\BlendedConcept\StoryBook\Application\Mappers\StoryBookMapper;
use Src\BlendedConcept\StoryBook\Application\Requests\StoreBookRequest;
use Src\BlendedConcept\StoryBook\Application\Requests\UpdateStoryBookRequest;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\CreateStoreStoryBookCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\UpdateStoryBookCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetDevice;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetDisabilityType;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetLearningNeed;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetTheme;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class BookController
{
    public function index()
    {
        $learningneeds = (new GetLearningNeed())->handle();

        $themes = (new GetTheme())->handle();

        $disability_types = (new GetDisabilityType())->handle();

        $devices = (new GetDevice())->handle();

        $filers = request()->only(['search', 'name', 'perPage']) ?? [];

        $storybooks = (new GetStoryBook($filers))->handle();

        return Inertia::render(config('route.books.index'), compact('learningneeds', 'themes', 'disability_types', 'devices', 'storybooks'));
    }

    public function store(StoreBookRequest $request)
    {
        try {
            $newStoryBook = StoryBookMapper::fromRequest($request);
            $StoryBookEloquent = (new CreateStoreStoryBookCommand($newStoryBook));
            $StoryBookEloquent->execute();

            return to_route('books.index')->with('successMessage', 'StoryBook Created Successfully!');
        } catch (\Exception $th) {
            return to_route('books.index')->with('sytemErrorMessage', 'StoryBook is not created!');
        }
    }

    public function update(UpdateStoryBookRequest $request, StoryBookEloquentModel $book)
    {

        try {
            $updateStoryBook = StoryBookData::fromRequest($request, $book->id);
            $updateStoryBook = (new UpdateStoryBookCommand($updateStoryBook));
            $updateStoryBook->execute();

            return to_route('books.index')->with('successMessage', 'StoryBook updated Successfully!');
        } catch (\Exception $th) {
            return to_route('books.index')->with('sytemErrorMessage', 'Something unexcepted happened');
        }
    }
}
