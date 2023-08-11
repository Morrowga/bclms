<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class SiteSetting extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $site_name,
        public readonly string $ssl,
        public readonly ?string $timezone,
        public readonly ?int $locale,
        public readonly ?int $email,
        public readonly ?int $contact_number,
    ) {
    }

    public function toArray(): array
    {
        return [

            'id' => $this->id,
            'site_name' => $this->site_name,
            'ssl' => $this->ssl,
            'timezone' => $this->timezone,
            'locale' => $this->locale,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
        ];
    }
}
