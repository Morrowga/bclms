<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Src\BlendedConcept\System\Application\UseCases\Queries\GetSiteSetting;
use Src\Common\Infrastructure\Laravel\Controller;
use Inertia\Inertia;
use Src\BlendedConcept\Infrastructure\EloquentModels\SiteSettingEloquentModel;
use Src\BlendedConcept\System\Application\DTO\SiteSettingData;
use Src\BlendedConcept\System\Application\UseCases\Commands\UpdateSiteSettingCommand;
use Src\BlendedConcept\System\Domain\Requests\UpdateSettingRequest;

class SettingController extends Controller
{


  public function index()
  {
    $this->authorize('view',SiteSettingEloquentModel::class);
    $setting = (new GetSiteSetting())->handle();
    return Inertia::render('BlendedConcept/System/Presentation/Resources/Settings/Index',compact('setting'));
  }

  public function UpdateSetting(UpdateSettingRequest $request)
  {
     $site_setting = SiteSettingData::fromRequest($request);
     $update_setting = (new UpdateSiteSettingCommand($site_setting));
     $update_setting->execute();
  }
}
