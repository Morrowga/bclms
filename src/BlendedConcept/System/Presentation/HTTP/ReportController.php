<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\System\Application\Policies\ExportDataPolicy;
use Src\Common\Infrastructure\Laravel\Controller;

class ReportController extends Controller
{
    public function index()
    {
        abort_if(authorize('view', ExportDataPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render(config('route.reports.reports'));
    }
}
