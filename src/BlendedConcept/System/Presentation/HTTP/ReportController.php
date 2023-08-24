<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return Inertia::render(config('route.reports.reports'));
    }
}
