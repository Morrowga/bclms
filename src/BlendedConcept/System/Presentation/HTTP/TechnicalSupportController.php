<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\System\Application\Mappers\TechnicalSupportMapper;
use Src\BlendedConcept\System\Application\Requests\AnswerTechnicalSupportRequest;
use Src\BlendedConcept\System\Application\Requests\QuestionTechnicalSupportRequest;
use Src\BlendedConcept\System\Application\UseCases\Commands\CreateTicketDetailCommand;
use Src\BlendedConcept\System\Application\UseCases\Commands\DeleteTicketCommand;
use Src\BlendedConcept\System\Application\UseCases\Queries\getTechnicalSupportQueries;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\TechnicalSupportEloquentModel;
use Src\Common\Infrastructure\Laravel\Controller;

class TechnicalSupportController extends Controller
{
    public function index()
    {

        $filters = request(['search', 'page', 'perPage', 'filter']);

        $technicalSupportList = (new getTechnicalSupportQueries($filters))->handle();

        return Inertia::render(config('route.support.index'), [
            'technicalSupportList' => $technicalSupportList,
        ]);
    }

    public function techsupports()
    {

        $filters = request(['search', 'page', 'perPage']);

        $technicalSupportList = (new getTechnicalSupportQueries($filters))->handle();

        return Inertia::render(
            config('route.support.techsupport'),
            ['technicalSupportList' => $technicalSupportList]
        );
    }

    public function askSupportQuestion(QuestionTechnicalSupportRequest $request)
    {
        try {
            $technicalSupport = TechnicalSupportMapper::fromRequest($request);
            $technicalSupportCommand = new CreateTicketDetailCommand($technicalSupport);
            $technicalSupportCommand->execute();

            return redirect()->route('techsupports')->with('successMessage', 'Asked question successfully!');
        } catch (\Exception $error) {

            dd($error->getMessage());

            return redirect()->route('techsupports')->with(['systemErrorMessage' => $error->getMessage()]);
        }
    }

    public function answerSupportQuestion(AnswerTechnicalSupportRequest $request, TechnicalSupportEloquentModel $support_ticket)
    {

        $request->validated();

        $support_ticket->update([
            'response' => $request->response,
            'has_responded' => true,
        ]);
    }

    public function deleteSupportQuestion(TechnicalSupportEloquentModel $support_ticket)
    {
        try {
            (new DeleteTicketCommand($support_ticket))->execute();

            return redirect()->back()->with('successMessage', 'You have successfully deleted!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());

        }
    }
}
