<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;


class PlanController
{


    public function index()
    {

        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Plans/Index');
    }
}
