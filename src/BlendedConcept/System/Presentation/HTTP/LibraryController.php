<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Src\Common\Infrastructure\Laravel\Controller;

class LibraryController extends Controller
{
    /**
     * Display the file manager view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize('view');
        return view('filemanager');
    }
}
