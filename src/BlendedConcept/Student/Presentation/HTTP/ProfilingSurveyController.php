<?php

namespace Src\BlendedConcept\Student\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Student\Application\Requests\ProfilingSubmitRequest;
use Src\BlendedConcept\Survey\Application\UseCases\Queries\Profiling\GetProfilingSurvey;

class ProfilingSurveyController
{
    public function index()
    {
        try {
            $profilingSurvey = (new GetProfilingSurvey())->handle();

            return Inertia::render(config('route.teacher_students.profiling_surveys'), compact('profilingSurvey'));
        } catch (\Exception $e) {
            return redirect()->route('teacher_students.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function submitProfilingSurvey(ProfilingSubmitRequest $request)
    {

    }
}
