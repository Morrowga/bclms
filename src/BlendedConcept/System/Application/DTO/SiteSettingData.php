<?php

namespace Src\BlendedConcept\System\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SiteSettingEloquentModel;

class SiteSettingData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $site_name,
        public readonly ?string $ssl,
        public readonly string $site_time_zone,
        public readonly string $site_locale,
        public readonly string $email,
        public readonly string $contact_number,
        public readonly ?string $website_logo,
        public readonly ?string $website_favicon,

    ) {
    }

    public static function fromRequest(Request $request, $setting_id = null): SiteSettingData
    {
        return new self(
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

    public static function fromEloquent(SiteSettingEloquentModel $site_setting): self
    {
        return new self(
            id: $site_setting->id,
            site_name: $site_setting->site_name,
            ssl: $site_setting->ssl,
            site_time_zone: $site_setting->site_time_zone,
            site_locale: $site_setting->site_locale,
            email: $site_setting->email,
            contact_number: $site_setting->contact_number,
            website_logo: $site_setting->website_logo,
            website_favicon: $site_setting->website_favicon
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'site_name' => $this->site_name,
            'ssl' => $this->ssl,
            'site_time_zone' => $this->site_time_zone,
            'site_locale' => $this->site_locale,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'website_logo' => $this->website_logo,
            'website_favicon' => $this->website_favicon,
        ];
    }
}
