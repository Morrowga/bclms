<?php

namespace Src\BlendedConcept\System\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\SystemThemeEloquentModel;

class SiteThemData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $skins,
        public readonly string $themes,
        public readonly string $primary_color,
        public readonly string $secondary_color,
        public readonly string $content_with,
        public readonly string $header_type,
        public readonly string $footer_type,
        public readonly string $menu_type,

    ) {
    }

    public static function fromRequest(Request $request, $site_theme_id = null): SiteThemData
    {
        return new self(
            id: $site_theme_id,
            skins: $request->skins,
            themes: $request->themes,
            primary_color: $request->primary_color,
            secondary_color: $request->secondary_color,
            content_with: $request->content_with,
            header_type: $request->header_type,
            footer_type: $request->footer_type,
            menu_type: $request->menu_type
        );
    }

    public static function fromEloquent(SystemThemeEloquentModel $site_setting): self
    {
        return new self(
            id: $site_setting->id,
            skins: $site_setting->skins,
            themes: $site_setting->themes,
            primary_color: $site_setting->primary_color,
            secondary_color: $site_setting->secondary_color,
            content_with: $site_setting->content_with,
            header_type: $site_setting->header_type,
            footer_type: $site_setting->footer_type,
            menu_type: $site_setting->menu_type
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'skins' => $this->skins,
            'themes' => $this->themes,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'content_with' => $this->content_with,
            'header_type' => $this->header_type,
            'footer_type' => $this->footer_type,
            'menu_type' => $this->menu_type,
        ];
    }
}
