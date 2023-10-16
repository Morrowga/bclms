<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\DTO\PathwayData;
use Src\BlendedConcept\StoryBook\Application\Mappers\PathwayMapper;
use Src\BlendedConcept\StoryBook\Application\Requests\StorePathwayRequest;
use Src\BlendedConcept\StoryBook\Application\Requests\UpdatePathwayRequest;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\Pathways\DeletePathwayCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\Pathways\StorePathwayCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\Pathways\UpdatePathwayCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStorybookForSelect;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\Pathways\GetPathwaysQuery;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\PathwayEloquentModel;

class PathwayController
{
    public function index()
    {
        $filters = request(['search', 'page', 'perPage']);
        $pathways = (new GetPathwaysQuery($filters))->handle();

        return Inertia::render(config('route.pathways.index'), [
            'pathways' => $pathways,
        ]);
    }

    public function store(StorePathwayRequest $request)
    {
        try {
            // Abort if the user is not authorized to create Pathway
            // abort_if(authorize('create', PathwayPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data

            $request->validated();
            $pathwayRequest = PathwayMapper::fromRequest($request);
            $savePathway = (new StorePathwayCommand($pathwayRequest));
            $savePathway->execute();

            return redirect()->route('pathways.index')->with('successMessage', 'Pathway Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('pathways.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function show(PathwayEloquentModel $pathway)
    {
        return Inertia::render(config('route.pathways.show'), [
            'pathway' => $pathway->load('storybooks'),
        ]);
    }

    public function edit(PathwayEloquentModel $pathway)
    {

        $storybooks = (new GetStorybookForSelect())->handle();

        return Inertia::render(config('route.pathways.edit'), [
            'storybooks' => $storybooks,
            'pathway' => $pathway->load('storybooks'),
        ]);
    }

    public function create()
    {
        $storybooks = (new GetStorybookForSelect())->handle();

        return Inertia::render(config('route.pathways.create'), [
            'storybooks' => $storybooks,
        ]);
    }

    public function update(UpdatePathwayRequest $request, $id)
    {
        try {

            $pathway = PathwayEloquentModel::findOrFail($id);
            $updatePathway = PathwayData::fromRequest($request, $pathway);
            $updatePathwaycommand = (new UpdatePathwayCommand($updatePathway));
            $updatePathwaycommand->execute();

            return redirect()->route('pathways.index')->with('successMessage', 'Pathway Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('pathways.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }

    public function destroy($id)
    {
        try {
            $pathway = PathwayEloquentModel::findOrFail($id);
            $deletePathwayCommand = (new DeletePathwayCommand($pathway));
            $deletePathwayCommand->execute();

            return redirect()->route('pathways.index')->with('successMessage', 'Pathway Created Successfully!');
        } catch (\Exception $error) {
            return redirect()
                ->route('pathways.index')
                ->with([
                    'systemErrorMessage' => $error->getCode(),
                ]);
        }
    }
}
