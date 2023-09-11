<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\System\Application\Requests\QuestionTechnicalSupportRequest;
use Src\Common\Infrastructure\Laravel\Controller;

class TechnicalSupportController extends Controller
{
    public function index()
    {

        return Inertia::render(config('route.support.index'));
    }

    public function techsupports()
    {
        return Inertia::render(config('route.support.techsupport'));
    }

    public function askSupportQuestion(QuestionTechnicalSupportRequest $request)
    {
        return $request->all();
    }
}
