<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;


use Src\Common\Infrastructure\Laravel\Controller;


use Inertia\Inertia;

class StudentController extends Controller
{




  public function create()
  {
    return Inertia::render('BlendedConcept/User/Presentation/Resources/Students/Create');
  }

  public function dashboard()
  {
    return Inertia::render('BlendedConcept/User/Presentation/Resources/Students/Dashboard');
  }

}
