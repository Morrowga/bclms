<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\System\Application\DTO\SiteSettingData;
use Src\BlendedConcept\System\Domain\Repositories\SettingRepositoryInterface;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SiteSettingEloquentModel;
use Src\BlendedConcept\System\Application\DTO\SiteThemData;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SystemThemeEloquentModel;
class SettingRepository implements SettingRepositoryInterface
{
    /**
     * Update the site setting using the provided SiteSettingData.
     * where you get first value inside site settings that update it
     * according to data change from admin etc.
     *
     * @param  SiteSettingData  $siteSettingData The data object containing the site setting values.
     * @return void
     */
    public function updateSetting(SiteSettingData $siteSettingData)
    {

        $siteSettingArray = $siteSettingData->toArray();
        $siteEloquent = SiteSettingEloquentModel::query()->first();

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
        return SiteSettingEloquentModel::first();
    }

    public function updateSiteTheme(SiteThemData $siteThemData)
    {
          $siteThemDataArray = $siteThemData->toArray();
          $siteEloquent = SystemThemeEloquentModel::query()->first();
          $siteEloquent->fill($siteThemDataArray);
          $siteEloquent->save();
    }
}
