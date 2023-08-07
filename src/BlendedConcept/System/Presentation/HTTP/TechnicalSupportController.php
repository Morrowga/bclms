<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;

use Src\Common\Infrastructure\Laravel\Controller;



class TechnicalSupportController extends Controller
{
   public function index()
   {
    return Inertia::render(config('route.support.index'));
   }
}
