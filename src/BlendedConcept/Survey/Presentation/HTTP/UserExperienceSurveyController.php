<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\Survey\Application\DTO\SurveyData;
use Src\BlendedConcept\Survey\Domain\Policies\SurveyPolicy;
use Src\BlendedConcept\Survey\Application\Mappers\SurveyMapper;
use Src\BlendedConcept\Security\Application\Policies\UserPolicy;
use Src\BlendedConcept\Survey\Application\Requests\StoreSurveyRequest;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\ShowSurvey;
use Src\BlendedConcept\Survey\Application\Requests\UpdateSurveyRequest;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey\StoreSurveyCommand;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey\DeleteSurveyCommand;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey\UpdateSurveyCommand;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\GetUserExperienceSurveyList;

class UserExperienceSurveyController
{
    public function index()
    {

        // Authorize user
        abort_if(authorize('view', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            // Get filters from request
            $filters = request()->only(['title', 'search', 'perPage']);

            // Get user list
            $surveys = (new GetUserExperienceSurveyList())->handle();

            // return $surveys;
            // Render Inertia view
            return Inertia::render(config('route.userexperiencesurvey.index'), [
                'surveys' => $surveys,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('userexperiencesurvey.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function create()
    {

        return Inertia::render(config('route.userexperiencesurvey.create'));
    }

    public function store(StoreSurveyRequest $request)
    {
        abort_if(authorize('create', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

    public function edit($id)
    {
        abort_if(authorize('edit', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $survey = (new ShowSurvey($id))->handle();

        // dd('hello');
        return Inertia::render(config('route.userexperiencesurvey.edit'), [
            'survey' => $survey,
        ]);
    }

    /**
     * Update an survey.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSurveyRequest $request,SurveyEloquentModel $userexperiencesurvey)
    {
        abort_if(authorize('edit', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Validate the request.
         */
        $request->validated();

        /**
         * Try to update the survey.
         */
        try {
            $surveyData = SurveyData::fromRequest($request, $userexperiencesurvey->id);
            $updateSurveyCommand = (new UpdateSurveyCommand($surveyData));
            $updateSurveyCommand->execute();

            return redirect()->route('userexperiencesurvey.index')->with('successMessage', 'Survey updated Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('userexperiencesurvey.index')->with('SystemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Delete an survey.
     *
     * @param  SurveyEloquentModel  $survey to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SurveyEloquentModel $userexperiencesurvey)
    {
        abort_if(authorize('destroy', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        /**
         * Try to delete the announcement.
         */
        try {
            $deleteSurvey = new DeleteSurveyCommand($userexperiencesurvey->id);
            $deleteSurvey->execute();

            return redirect()->route('userexperiencesurvey.index')->with('successMessage', 'Survey deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('userexperiencesurvey.index')->with('systemErrorMessage', $e->getMessage());
        }
    }
}
