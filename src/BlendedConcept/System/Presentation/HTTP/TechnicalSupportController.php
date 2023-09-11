<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\System\Domain\Model\Entities\TechnicalSupport;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\System\Application\Requests\QuestionTechnicalSupportRequest;
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
