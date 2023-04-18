<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;


use Src\Common\Infrastructure\Laravel\Controller;


use Inertia\Inertia;

class SettingController extends Controller
{

  public function index()
  {
    return Inertia::render('BlendedConcept/User/Presentation/Resources/Settings/Index');
  }
}
