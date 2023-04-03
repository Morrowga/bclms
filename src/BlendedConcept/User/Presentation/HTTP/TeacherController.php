<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;


use Src\Common\Infrastructure\Laravel\Controller;


use Inertia\Inertia;

class TeacherController extends Controller
{

    public function dashboard()
    {
        return Inertia::render('BlendedConcept/User/Presentation/Resources/Teachers/Dashboard');
    }
}
