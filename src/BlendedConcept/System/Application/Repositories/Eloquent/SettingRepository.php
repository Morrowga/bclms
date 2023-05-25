<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\System\Application\DTO\SiteSettingData;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SiteSettingEloquentModel;
use Src\BlendedConcept\System\Domain\Repositories\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    public function updateSetting(SiteSettingData $siteSettingData)
    {

        $siteSettingArray = $siteSettingData->toArray();
        $siteEloquent = SiteSettingEloquentModel::query()->find(1);

        $siteEloquent->fill($siteSettingArray);
        $siteEloquent->save();

        if (request()->hasFile('site_logo') && request()->file('site_logo')->isValid()) {

            $siteEloquent->clearMediaCollection('site_logo');
            $siteEloquent->addMediaFromRequest('site_logo')->toMediaCollection('site_logo', 'media_sitelogo');
        }

        if (request()->hasFile('fav_icon') && request()->file('fav_icon')->isValid()) {

            $siteEloquent->clearMediaCollection('fav_icon');
            $siteEloquent->addMediaFromRequest('fav_icon')->toMediaCollection('fav_icon', 'media_sitefavico');

        }
    }


    public function getSetting()
    {
        return SiteSettingEloquentModel::find(1);
    }

}
