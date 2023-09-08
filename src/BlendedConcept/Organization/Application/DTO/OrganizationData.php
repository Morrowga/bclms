<?php

namespace Src\BlendedConcept\Organization\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Finance\Application\Mappers\PlanMapper;
use Src\BlendedConcept\Finance\Domain\Model\Entities\Plan;

class OrganizationData
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $curr_subscription_id,
        public readonly ?int $org_admin_id,
        public readonly ?string $name,
        public readonly ?string $contact_name,
        public readonly ?string $contact_email,
        public readonly ?int $contact_number,
        public readonly ?string $sub_domain,
        public readonly ?string $logo,
        public readonly ?string $status,
    ) {
    }

    public static function fromRequest(Request $request, $organizaton): OrganizationData
    {
        return new self(
            id: $organizaton->id,
            curr_subscription_id: $request->curr_subscription_id,
            org_admin_id: $request->org_admin_id,
            name: $request->name,
            contact_name: $request->contact_name,
            contact_email: $request->contact_email,
            contact_number: $request->contact_number,
            sub_domain: $request->sub_domain,
            logo: $request->logo,
            status: $request->status
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'curr_subscription_id' => $this->curr_subscription_id,
            'org_admin_id' => $this->org_admin_id,
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_number' => $this->contact_number,
            'sub_domain' => $this->sub_domain,
            'logo' => $this->logo,
            'status' => $this->status,
        ];
    }
}
