<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

interface SettingRepositoryInterface
{
    // update settings


    public function updateSetting($request);


    public function getSetting();

}
