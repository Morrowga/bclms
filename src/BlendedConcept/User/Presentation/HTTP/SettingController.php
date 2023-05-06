<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;
use Src\Common\Infrastructure\Laravel\Controller;
use Inertia\Inertia;
use Src\BlendedConcept\User\Domain\Model\Setting;
use Src\BlendedConcept\User\Domain\Requests\UpdateSettingRequest;
use Src\BlendedConcept\User\Domain\Repositories\SettingRepositoryInterface;
class SettingController extends Controller
{


    private $SettingRepositoryInterface;

    public function __construct(SettingRepositoryInterface $SettingRepositoryInterface)
    {
      $this->SettingRepositoryInterface = $SettingRepositoryInterface;
    }

  public function index()
  {
    $this->authorize('view', Setting::class);
    $setting = $this->SettingRepositoryInterface->getSetting();
    return Inertia::render('BlendedConcept/User/Presentation/Resources/Settings/Index',compact('setting'));
  }

  public function UpdateSetting(UpdateSettingRequest $request)
  {
     $this->SettingRepositoryInterface->updateSetting($request);
  }
}
