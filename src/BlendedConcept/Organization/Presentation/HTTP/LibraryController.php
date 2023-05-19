<?php

namespace Src\BlendedConcept\Organization\Presentation\HTTP;
use Src\Common\Infrastructure\Laravel\Controller;
class LibraryController extends Controller
{
    /***
     *  this method is for laravel filemanager
     */
    public function index()
    {
        $this->authorize('view');
        return view('filemanager');
    }
}
