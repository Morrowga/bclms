<?php

namespace Src\BlendedConcept\User\Domain\Repositories;

interface SettingRepositoryInterface
{
    // update settings


    public function updateSetting($request);


    public function getSetting();

}
