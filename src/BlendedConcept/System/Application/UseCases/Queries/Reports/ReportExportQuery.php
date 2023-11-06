<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries\Reports;

use Src\Common\Domain\QueryInterface;
use Src\BlendedConcept\System\Domain\Repositories\ReportRepositoryInterface;

class ReportExportQuery implements QueryInterface
{
    private ReportRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(ReportRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->reportExport();
    }
}
