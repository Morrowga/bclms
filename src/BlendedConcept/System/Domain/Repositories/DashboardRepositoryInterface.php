<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

use Src\BlendedConcept\System\Application\DTO\AnnounmentData;

interface DashboardRepositoryInterface
{

    public function getRecentOrganisations($filters);
    public function getRecentUsers($filters);
    public function getRecentBooks();
    public function getRecentGames();
    public function getRecentSurveys($filters);
    public function getRecentStudents($filters);
}
