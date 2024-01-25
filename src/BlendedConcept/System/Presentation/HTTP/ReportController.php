<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Src\Common\Application\Exports\ReportExport;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\Common\Application\Exports\ReportGameExport;
use Src\BlendedConcept\System\Application\Policies\ExportDataPolicy;
use Src\BlendedConcept\System\Application\UseCases\Queries\Reports\ReportGameQuery;
use Src\BlendedConcept\System\Application\UseCases\Queries\Reports\ReportExportQuery;
use Src\BlendedConcept\System\Application\UseCases\Queries\Reports\ReportStorybookQuery;

class ReportController extends Controller
{
    public function index()
    {
        abort_if(authorize('view', ExportDataPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render(config('route.reports.reports'));
    }

    public function reportExport()
    {
        $data = (new ReportExportQuery())->handle();

        return Excel::download(new ReportExport($data), 'reports.xlsx');
    }

    public function gameExport()
    {
        $data = (new ReportGameQuery())->handle();

        return Excel::download(new ReportGameExport($data), 'game-reports.xlsx');
    }

    public function storybookExport()
    {
        $data = (new ReportStorybookQuery())->handle();

        return Excel::download(new ReportExport($data), 'storybook-reports.xlsx');
    }
}
