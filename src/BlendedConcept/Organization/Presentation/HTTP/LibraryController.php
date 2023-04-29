<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;

class LibraryController extends Controller
{


    public function index()
    {
        return Inertia::render('BlendedConcept/Organization/Presentation/Resources/Libraries/Index');
    }
}
