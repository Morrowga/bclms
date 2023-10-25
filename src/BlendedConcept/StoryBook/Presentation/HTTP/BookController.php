<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;
use Src\BlendedConcept\Library\Application\UseCases\Commands\UpdateResourceCommand;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookData;
use Src\BlendedConcept\StoryBook\Application\Mappers\StoryBookMapper;
use Src\BlendedConcept\StoryBook\Application\Requests\StoreBookRequest;
use Src\BlendedConcept\StoryBook\Application\Requests\UpdateStoryBookRequest;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\Books\DeleteBookCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\CreateStoreStoryBookCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\UpdatePhysicalResourcesCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\UpdateStoryBookCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetDevice;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetDisabilityType;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetLearningNeed;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStoryBook;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStudentStorybooks;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetTheme;
use Src\BlendedConcept\StoryBook\Domain\Policies\BookPolicy;
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
        abort_if(authorize('view', BookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
        abort_if(authorize('store', BookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(authorize('update', BookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(authorize('create', BookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $learningneeds = (new GetLearningNeed())->handle();
        $themes = (new GetTheme())->handle();
        $disability_types = (new GetDisabilityType())->handle();
        $devices = (new GetDevice())->handle();

        return Inertia::render(config('route.books.create'), compact('learningneeds', 'themes', 'disability_types', 'devices', 'tags'));
    }

    public function edit(StoryBookEloquentModel $book)
    {
        // dd($book);
        abort_if(authorize('edit', BookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render(config('route.books.edit'), compact('book'));
    }

    public function updatePhysicalResources(Request $request, StoryBookEloquentModel $book)
    {
        try {
            $updateResources = new UpdatePhysicalResourcesCommand($request, $book);
            $updateResources->execute();
            return redirect()->back()->with('successMessage', 'StoryBook updated Successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->with('systemErrorMessage', 'Something unexpected happened');
        }
    }
    public function destroy(StoryBookEloquentModel $book)
    {
        abort_if(authorize('destroy', BookPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $deleteBookCommand = (new DeleteBookCommand($book));
            $deleteBookCommand->execute();

            return redirect()->route('books.index')->with('successMessage', 'Book Deleted Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('books.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
