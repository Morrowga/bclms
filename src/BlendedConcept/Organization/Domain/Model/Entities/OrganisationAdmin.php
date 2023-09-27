<?php

namespace Src\BlendedConcept\Organization\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class OrganisationAdmin extends Entity
{
    public function __construct(
        public readonly ?int $org_admin_id,
        public readonly ?int $user_id,
        public readonly ?int $organisation_id
    ) {
    }

    public function toArray(): array
    {
        return [
            'org_admin_id' => $this->org_admin_id,
            'user_id' => $this->user_id,
            'organisation_id' => $this->organisation_id,
        ];
    }
}
