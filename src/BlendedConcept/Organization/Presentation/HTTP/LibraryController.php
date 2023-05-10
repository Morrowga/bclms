<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;

use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;

use Src\BlendedConcept\User\Domain\Repositories\SettingRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
class LibraryController extends Controller
{




    public function index()
    {
        return view('filemanager');
    }
}
