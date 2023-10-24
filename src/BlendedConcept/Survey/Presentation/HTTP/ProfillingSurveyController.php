<?php

namespace Src\BlendedConcept\Survey\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\Survey\Domain\Policies\SurveyPolicy;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\Profiling\GetProfilingSurvey;
use Src\BlendedConcept\Survey\Application\UseCases\Commands\Survey\Profiling\StoreOrderCommand;
use Src\BlendedConcept\Survey\Domain\Policies\ProfillingSurveyPolicy;

class ProfillingSurveyController
{
    public function index()
    {
        // Authorize user
        abort_if(authorize('view', ProfillingSurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            $survey = (new GetProfilingSurvey())->handle();

            return Inertia::render(config('route.profilling_survey.index'), [
                'survey' => $survey,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('profilling_survey.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function saveOrder(Request $request, SurveyEloquentModel $profilingSurvey)
    {
        abort_if(authorize('store', ProfillingSurveyPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            // Creates a new StoreSurveyCommand object and executes it.
            $storeStoreCommand = new StoreOrderCommand($request, $profilingSurvey);
            $storeStoreCommand->execute();

            return response()->json('success');
        } catch (\Exception $e) {
            // Handle the exception here
            dd($e->getMessage());

            return redirect()->route('profilling_survey.index')->with('systemErrorMessage', $e->getMessage());
        }
    }
}
