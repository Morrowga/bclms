<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\Survey\Domain\Policies\SurveyResponsePolicy;
use Src\BlendedConcept\Survey\Application\Requests\StoreSurveyResponseRequest;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\ResponseEloquentModel;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Response\DeleteResponseCommand;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey\StoreSurveyResponseCommand;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResponses\GetSurveyResponses;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\SurveyResponses\GetUserSurveyResponses;

class SurveyResponseController
{
    public function index()
    {
        abort_if(authorize('view', SurveyResponsePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $filters = request()->only(['question', 'search', 'perPage', 'filter']);

            $surveyResponses = (new GetSurveyResponses($filters))->handle();
            return Inertia::render(config('route.surveyresponse.index'), [
                'surveyResponses' => $surveyResponses,
            ]);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('surveyresponse.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function show(SurveyEloquentModel $surveyresponse, Request $request)
    {
        abort_if(authorize('view', SurveyResponsePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userSurveyResponse = (new GetUserSurveyResponses($surveyresponse->id, $request->query('user_id'), $request->query('response_datetime')))->handle();
        $user = UserEloquentModel::find($request->query('user_id'));

        return Inertia::render(config('route.surveyresponse.show'), [
            'surveyresponse' => $userSurveyResponse,
            'user' => $user
        ]);
    }

    public function view(SurveyEloquentModel $survey)
    {
        abort_if(authorize('view', SurveyResponsePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render(config('route.surveyresponse.view'), [
            'survey' => $survey->load('survey_settings', 'questions', 'responses')
        ]);
    }

    public function store(StoreSurveyResponseRequest $request)
    {
        // abort_if(authorize('store', SurveyResponsePolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $request->validated();
            // Creates a new StoreSurveyResponseCommand object and executes it.
            $storeSurveyResponseCommand = new StoreSurveyResponseCommand($request);
            $storeSurveyResponseCommand->execute();
            return redirect()->route('teacher_students.index');
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
        /**
         * Returns a redirect response to the surveys index page.
         */

        return $request->type == 'USEREXP' ? redirect()->route('dashboard') : redirect()->route('teacher_students.show', UserEloquentModel::find($request->user_id)->student->student_id);
    }


    /**
     * Delete a response.
     *
     * @param  ResponseEloquentModel  $survey to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ResponseEloquentModel $surveyresponse)
    {
        abort_if(authorize('destroy', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        /**
         * Try to delete the announcement.
         */
        try {
            $deleteResponse = new DeleteResponseCommand($surveyresponse->id);
            $deleteResponse->execute();

            return redirect()->route('surveyresponse.index')->with('successMessage', 'Response deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}
