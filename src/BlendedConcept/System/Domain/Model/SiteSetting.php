<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class SiteSetting extends AggregateRoot
{

    public function __construct(
        public readonly ?int $id,
        public readonly string $site_name,
        public readonly ?string $ssl,
        public readonly string $site_time_zone,
        public readonly string $site_locale,
        public readonly string $email,
        public readonly string $contact_number,
        public readonly string $website_logo,
        public readonly string $website_favicon,
    ) {
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "site_name" => $this->site_name,
            "ssl" => $this->ssl,
            "site_time_zone" => $this->site_time_zone,
            "site_locale" => $this->site_locale,
            "email" => $this->email,
            "contact_number" => $this->contact_number,
            "website_logo" => $this->website_logo,
            "website_favicon" => $this->website_favicon,
        ];
    }
}
