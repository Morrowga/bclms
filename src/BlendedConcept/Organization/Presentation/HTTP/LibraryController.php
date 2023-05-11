<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;
use Src\Common\Infrastructure\Laravel\Controller;
class LibraryController extends Controller
{




    public function index()
    {
        $this->authorize('view');
        return view('filemanager');
    }
}
