<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveyEloquentModel;
use Src\BlendedConcept\System\Domain\Repositories\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getRecentOrganisations($filters)
    {
        $organisations = OrganisationEloquentModel::filter($filters)->paginate($filters['perPage'] ?? 10);
        return $organisations;
    }

    public function getRecentUsers($filters)
    {
        $users = UserEloquentModel::filter($filters)->with('role')->paginate($filters['perPage'] ?? 10);
        return $users;
    }

    public function getRecentBooks()
    {
        $books = StoryBookEloquentModel::with(['learningneeds', 'themes', 'disability_types', 'devices', 'tags'])
            ->orderBy('id', 'desc')->paginate(10);
        return $books;
    }

    public function getRecentGames()
    {
        $games = GameEloquentModel::with(['tags', 'disabilityTypes', 'devices'])->orderBy('id', 'desc')->paginate(10);
        return $games;
    }

    public function getRecentSurveys($filters)
    {
        $surveys = SurveyEloquentModel::filter($filters)->where('type', 'USEREXP')->orderBy('id', 'desc')->with(['survey_settings'])->paginate($filters['perPage'] ?? 10);
        return $surveys;
    }

    public function getRecentStudents($filters)
    {
        $teacher_id = auth()->user()->b2bUser->teacher_id;
        $students =
            StudentEloquentModel::with('user', 'organisation', 'disability_types', 'parent')
            ->filter($filters)
            ->whereHas('teachers', function ($query) use ($teacher_id) {
                $query->where('teachers.teacher_id', $teacher_id);
            })
            ->orderBy('student_id', 'desc')
            // ->where('organisation_id', auth()->user()->organisation_id)
            ->paginate($filters['perPage'] ?? 10);
        return $students;
    }
}
