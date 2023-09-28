<?php

namespace Src\BlendedConcept\Organisation\Application\DTO;

use Illuminate\Http\Request;


class OrganisationAdminData
{
    public function __construct(
        public readonly ?int $org_admin_id,
        public readonly ?int $user_id,
        public readonly ?int $organisation_id
    ) {
    }

    public static function fromRequest(Request $request, $organizatonAdmin): OrganisationAdminData
    {
        return new self(
            org_admin_id: $organizatonAdmin->id,
            user_id: $organizatonAdmin->user_id,
            organisation_id: $organizatonAdmin->organisation_id,
        );
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
