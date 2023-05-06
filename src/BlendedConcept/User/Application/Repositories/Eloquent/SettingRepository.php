<?php

namespace Src\BlendedConcept\User\Application\Repositories\Eloquent;

use Src\BlendedConcept\User\Domain\Model\Setting;
use Src\BlendedConcept\User\Domain\Repositories\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    public function updateSetting($request)
    {

        Setting::where("id", 1)->update([
            'site_name' => $request->site_name,
            'timezone' => $request->timezone,
            'locale' => $request->locale,
            "email" => $request->email,
            "contact_number" => $request->contact_number
        ]);

        $settings = Setting::find(1);

        if ($request->hasFile('site_logo') && $request->file('site_logo')->isValid()) {

            $settings->clearMediaCollection('site_logo');
            $settings->addMediaFromRequest('site_logo')->toMediaCollection('site_logo', 'media_sitelogo');
        }

        if ($request->hasFile('fav_icon') && $request->file('fav_icon')->isValid()) {

            $settings->clearMediaCollection('fav_icon');
            $settings->addMediaFromRequest('fav_icon')->toMediaCollection('fav_icon', 'media_sitefavico');

        }
    }


    public function getSetting()
    {
        return Setting::find(1);
    }

}
