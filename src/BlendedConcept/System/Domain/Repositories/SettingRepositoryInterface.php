<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

use Src\BlendedConcept\System\Application\DTO\SiteSettingData;

interface SettingRepositoryInterface
{

    public function updateSetting(SiteSettingData $siteSettingData);


    public function getSetting();

}
