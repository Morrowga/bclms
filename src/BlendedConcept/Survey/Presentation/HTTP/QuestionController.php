<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Src\BlendedConcept\Survey\Application\DTO\QuestionData;
use Src\BlendedConcept\Survey\Application\Requests\StoreQuestionRequest;
use Src\BlendedConcept\Survey\Application\Requests\UpdateQuestionRequest;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Question\DeleteQuestionCommand;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Question\StoreQuestionCommand;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Question\UpdateQuestionCommand;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\QuestionEloquentModel;

class QuestionController
{
    public function store(StoreQuestionRequest $request)
    {
        try {
            $request->validated();

            // Creates a new StoreSurveyCommand object and executes it.
            $storeQuestionCommand = new StoreQuestionCommand($request);
            $storeQuestionCommand->execute();
            /**
             * Returns a redirect response to the current survey's edit page.
             */
            if ($request->type == 'profiling') {
                return redirect()->route('profilling_survey.index')->with('successMessage', 'Question created Successfully!');
            }

            return redirect()->route('userexperiencesurvey.edit', $request->survey_id)->with('successMessage', 'Question created Successfully!');

        } catch (\Exception $e) {
            // Handle the exception here
            dd($e->getMessage());

            if ($request->type == 'profiling') {
                return redirect()->route('profilling_survey.index')->with('systemErrorMessage', $e->getMessage());
            }

            return redirect()->route('userexperiencesurvey.edit', $request->survey_id)->with('systemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Update an question.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateQuestionRequest $request, QuestionEloquentModel $question)
    {
        // abort_if(authorize('edit', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Validate the request.
         */
        $request->validated();

        /**
         * Try to update the question.
         */
        try {
            $questionFilter = QuestionData::fromRequest($request, $question);
            $updateQuestionCommand = (new UpdateQuestionCommand($questionFilter));
            $updateQuestionCommand->execute();

            if ($request->type == 'profiling') {
                return redirect()->route('profilling_survey.index')->with('successMessage', 'Question updated Successfully!');
            }

            return redirect()->route('userexperiencesurvey.edit', $question->survey_id)->with('successMessage', 'Question updated Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            if ($request->type == 'profiling') {
                return redirect()->route('profilling_survey.index')->with('SystemErrorMessage', $e->getMessage());
            }

            return redirect()->route('userexperiencesurvey.edit', $question->survey_id)->with('SystemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Delete an question.
     *
     * @param  QuestionEloquentModel  $question to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, QuestionEloquentModel $question)
    {
        // abort_if(authorize('destroy', SurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        /**
         * Try to delete the question.
         */
        try {
            $deleteQuestion = new DeleteQuestionCommand($question->id);
            $deleteQuestion->execute();

            if ($request->type == 'profiling') {
                return redirect()->route('profilling_survey.index')->with('successMessage', 'Question deleted Successfully!');
            }

            return redirect()->route('userexperiencesurvey.edit', $question->survey_id)->with('successMessage', 'Question deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            if ($request->type == 'profiling') {
                return redirect()->route('profilling_survey.index')->with('systemErrorMessage', $e->getMessage());
            }

            return redirect()->route('userexperiencesurvey.edit', $question->survey_id)->with('systemErrorMessage', $e->getMessage());
        }
    }
}
