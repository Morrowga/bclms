<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class SiteTheme extends Entity
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
