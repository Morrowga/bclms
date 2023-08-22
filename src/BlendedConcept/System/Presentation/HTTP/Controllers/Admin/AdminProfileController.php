<?php

namespace Src\BlendedConcept\System\Presentation\HTTP\Controllers\Admin;

use Src\Common\Infrastructure\Laravel\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AdminProfileController extends Controller
{
    public function index(): Response
    {
        return Inertia::render(config('route.organization.profile'));
    }
}