<?php

namespace Src\BlendedConcept\Disability\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Disability\Application\DTO\LearningNeedData;
use Src\BlendedConcept\Disability\Application\Mappers\LearningNeedMapper;
use Src\BlendedConcept\Disability\Application\Requests\StoreLearningNeedRequest;
use Src\BlendedConcept\Disability\Application\Requests\UpdateLearningNeedRequest;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\LearningNeeds\DeleteLearningNeedCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\LearningNeeds\StoreLearningNeedCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Commands\LearningNeeds\UpdateLearningNeedCommand;
use Src\BlendedConcept\Disability\Application\UseCases\Queries\LearningNeeds\GetLearningNeeds;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\LearningNeedEloquentModel;

class LearningNeedController
{
    public function index()
    {
        $filters = request(['search', 'page', 'perPage']);
        $learningNeeds = (new GetLearningNeeds($filters))->handle();

        return Inertia::render(config('route.disability_type.index'), [
            'disabilityTypes' => $learningNeeds,
        ]);
    }

    public function store(StoreLearningNeedRequest $request)
    {
        try {
            // Abort if the user is not authorized to create Learning Need
            // abort_if(authorize('create', LearningNeedPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data

            $request->validated();
            $learningNeedRequest = LearningNeedMapper::fromRequest($request);
            $savelearningNeed = (new StoreLearningNeedCommand($learningNeedRequest));
            $savelearningNeed->execute();

            return redirect()->route('learning_need.index')->with('successMessage', 'Learning Need Created Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }

    public function show()
    {
        return Inertia::render(config('route.plans.show'));
    }

    public function update(UpdateLearningNeedRequest $request, $id)
    {

        try {

            $learningNeed = LearningNeedEloquentModel::findOrFail($id);
            $updatelearningNeed = LearningNeedData::fromRequest($request, $learningNeed);
            $updatelearningNeedcommand = (new UpdateLearningNeedCommand($updatelearningNeed));
            $updatelearningNeedcommand->execute();

            return redirect()->route('learning_need.index')->with('successMessage', 'Learning Need Updated Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $learningNeed = learningNeedEloquentModel::findOrFail($id);
            $deletelearningNeedCommand = (new DeleteLearningNeedCommand($learningNeed));
            $deletelearningNeedCommand->execute();

            return redirect()->route('learning_need.index')->with('successMessage', 'Learning Need Deleted Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }
}
