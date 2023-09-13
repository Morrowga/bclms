<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

use Src\BlendedConcept\System\Application\DTO\SiteSettingData;
use Src\BlendedConcept\System\Application\DTO\SiteThemData;

interface SettingRepositoryInterface
{
    public function updateSetting(SiteSettingData $siteSettingData);

    public function getSetting();

    public function updateSiteTheme(SiteThemData $siteThemData);

    public function getSiteTheme();
}
