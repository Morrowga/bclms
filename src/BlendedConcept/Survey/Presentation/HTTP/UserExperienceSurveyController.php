<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Survey\Application\Mappers\SurveyMapper;
use Src\BlendedConcept\Survey\Application\Policies\SurveyPolicy;
use Src\BlendedConcept\Survey\Application\Requests\StoreSurveyRequest;
use Src\BlendedConcept\Survey\Application\Requests\StoreQuestionRequest;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\GetSurveyList;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\StoreSurveyCommand;

class UserExperienceSurveyController
{
    public function index()
    {

        // Authorize user
        // abort_if(authorize('view', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            // Get filters from request
            $filters = request()->only(['title', 'search', 'perPage']);

            // Get user list
            $surveys = (new GetSurveyList())->handle();
            // return $surveys;
            // Render Inertia view
            return Inertia::render(config('route.userexperiencesurvey.index'), [
                'surveys' => $surveys,
            ]);
        } catch (\Exception $e) {
            return Inertia::render(config('route.userexperiencesurvey.index'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function create()
    {

        return Inertia::render(config('route.userexperiencesurvey.create'));
    }

    public function store(StoreSurveyRequest $request){
        // abort_if(authorize('create', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $request->validated();
            //Creates a new survey object from the request data.
            $newSurvey = SurveyMapper::fromRequest($request);
            // Creates a new StoreSurveyCommand object and executes it.
            $storeSurveyCommand = new StoreSurveyCommand($newSurvey);
            $storeSurveyCommand->execute();
        } catch (\Exception $e) {

            // Handle the exception here
            dd($e->getMessage());

            return redirect()->route('userexperiencesurvey.index')->with('systemErrorMessage', $e->getMessage());
        }

        /**
         * Returns a redirect response to the surveys index page.
         */
        return redirect()->route('userexperiencesurvey.index')->with('successMessage', 'User Experience Survey created Successfully!');
    }

    public function show()
    {
        return Inertia::render(config('route.userexperiencesurvey.show'));
    }

    public function edit()
    {
        // dd('hello');
        return Inertia::render(config('route.userexperiencesurvey.edit'));
    }
}
