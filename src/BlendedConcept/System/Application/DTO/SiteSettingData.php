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
        public readonly ?string $timezone,
        public readonly ?string $locale,
        public readonly ?string $email,
        public readonly ?string $contact_number,

    ) {
    }

    public static function fromRequest(Request $request, $setting_id = null): SiteSettingData
    {

        return new self(
            id: $setting_id,
            site_name: $request->site_name,
            ssl: $request->ssl,
            timezone: $request->timezone,
            locale: $request->locale,
            email: $request->email,
            contact_number: $request->contact_number,
        );
    }

    public static function fromEloquent(SiteSettingEloquentModel $site_setting): self
    {
        return new self(

            id: $site_setting->id,
            site_name: $site_setting->site_name,
            ssl: $site_setting->ssl,
            timezone: $site_setting->timezone,
            locale: $site_setting->locale,
            email: $site_setting->email,
            contact_number: $site_setting->contact_number,
        );
    }

    public function toArray(): array
    {
        return [

            "id" => $this->id,
            "site_name" => $this->site_name,
            "ssl" => $this->ssl,
            "timezone" => $this->timezone,
            "locale" => $this->locale,
            "email" => $this->email,
            "contact_number" => $this->contact_number,
        ];
    }
}
