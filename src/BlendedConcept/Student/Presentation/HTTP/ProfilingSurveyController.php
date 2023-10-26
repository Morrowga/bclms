<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Student\Application\Requests\ProfilingSubmitRequest;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\Profiling\GetProfilingSurvey;

class ProfilingSurveyController
{
    public function index(UserEloquentModel $user)
    {
        try {
            $profilingSurvey = (new GetProfilingSurvey())->handle();
            $user->load('student');
            return Inertia::render(config('route.teacher_students.profiling_surveys'), compact('profilingSurvey', 'user'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}
