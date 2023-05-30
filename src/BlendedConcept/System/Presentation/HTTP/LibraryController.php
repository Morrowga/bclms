<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Src\BlendedConcept\System\Application\Policies\FileManagerPolicy;
use Src\Common\Infrastructure\Laravel\Controller;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends Controller
{
    /**
     * Display the file manager view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        abort_if(authorize('destroy', FileManagerPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('filemanager');
    }
}
