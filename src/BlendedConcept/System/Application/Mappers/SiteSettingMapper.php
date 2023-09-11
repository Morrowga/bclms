<?php

namespace Src\BlendedConcept\System\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Domain\Model\SiteSetting;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SiteSettingEloquentModel;

class SiteSettingMapper
{
    public static function fromRequest(Request $request, $setting_id = null): SiteSetting
    {
        return new SiteSetting(
            id: $setting_id,
            site_name: $request->site_name,
            ssl: $request->ssl,
            site_time_zone: $request->site_time_zone,
            site_locale: $request->site_locale,
            email: $request->email,
            contact_number: $request->contact_number,
            website_logo: $request->website_logo,
            website_favicon: $request->website_favicon
        );
    }


    public static function toEloquent(SiteSetting $siteSetting): SiteSettingEloquentModel
    {
        $siteSettingEloquent = new SiteSettingEloquentModel();

        if ($siteSetting->id) {
            $siteSettingEloquent = SiteSettingEloquentModel::query()->findOrFail($siteSetting->id);
        }
        $siteSettingEloquent->site_name = $siteSetting->site_name;
        $siteSettingEloquent->ssl = $siteSetting->ssl;
        $siteSettingEloquent->site_time_zone = $siteSetting->site_time_zone;
        $siteSettingEloquent->site_locale = $siteSetting->site_locale;
        $siteSettingEloquent->email = $siteSetting->email;
        $siteSettingEloquent->contact_number = $siteSetting->contact_number;
        $siteSettingEloquent->website_logo = $siteSetting->website_logo;
        $siteSettingEloquent->website_favicon = $siteSetting->website_favicon;
        return $siteSettingEloquent;
    }
}
