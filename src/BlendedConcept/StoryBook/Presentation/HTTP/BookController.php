<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Illuminate\Support\Facades\Cookie;
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
    /**
     * Display the index page with data for learning needs, themes, disability types, devices, and storybooks.
     *
     * @return \Inertia\Response
     * Author @hareom284
     */
    public function index()
    {
        // Retrieve learning needs, themes, disability types, and devices
        $learningneeds = (new GetLearningNeed())->handle();
        $themes = (new GetTheme())->handle();
        $disability_types = (new GetDisabilityType())->handle();
        $devices = (new GetDevice())->handle();

        // Retrieve storybooks based on filters
        $filters = request()->only(['search', 'name', 'perPage']) ?? [];
        $storybooks = (new GetStoryBook($filters))->handle();

        // Render the index page with the retrieved data
        return Inertia::render(config('route.books.index'), compact('storybooks', 'learningneeds', 'themes', 'disability_types', 'devices'));
    }

    /**
     * Store a new storybook based on the provided request.
     *
     * @return \Illuminate\Http\RedirectResponse
     * Author @hareom284
     */
    public function store(StoreBookRequest $request)
    {
        // $val = Cookie::get('h5p_id');
        // dd($val);
        try {
            // Map the request data to create a new storybook
            $newStoryBook = StoryBookMapper::fromRequest($request);

            // Create a new storybook using a command
            $StoryBookEloquent = new CreateStoreStoryBookCommand($newStoryBook);
            $StoryBookEloquent->execute();

            // Redirect to the index page with a success message
            return redirect()->route('books.index')->with('successMessage', 'StoryBook Created Successfully!');
        } catch (\Exception $th) {
            // Redirect to the index page with a system error message
            return redirect()->route('books.index')->with('systemErrorMessage', 'StoryBook is not created!');
        }
    }

    /**
     * Update an existing storybook based on the provided request.
     *
     * @param  StoryBookEloquentModel  $book The storybook to update
     * @return \Illuminate\Http\RedirectResponse
     * Author @hareom284
     */
    public function update(UpdateStoryBookRequest $request, StoryBookEloquentModel $book)
    {
        try {
            // Map the request data to update the storybook
            $updateStoryBook = StoryBookData::fromRequest($request, $book->id);

            // Update the storybook using a command
            $updateStoryBookCommand = new UpdateStoryBookCommand($updateStoryBook);
            $updateStoryBookCommand->execute();

            // Redirect to the index page with a success message
            return redirect()->route('books.index')->with('successMessage', 'StoryBook updated Successfully!');
        } catch (\Exception $th) {
            // Redirect to the index page with a system error message
            return redirect()->route('books.index')->with('systemErrorMessage', 'Something unexpected happened');
        }
    }

    public function create()
    {
        $learningneeds = (new GetLearningNeed())->handle();
        $themes = (new GetTheme())->handle();
        $disability_types = (new GetDisabilityType())->handle();
        $devices = (new GetDevice())->handle();

        return Inertia::render(config('route.books.create'), compact('learningneeds', 'themes', 'disability_types', 'devices',));
    }

    public function edit(StoryBookEloquentModel $book)
    {
        // dd($book);
        return Inertia::render(config('route.books.edit'), compact('book'));
    }
}
