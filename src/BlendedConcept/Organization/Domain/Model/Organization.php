<?php

namespace Src\BlendedConcept\Organization\Domain\Model;

use Src\BlendedConcept\ClassRoom\Domain\Model\ClassRoom;
use Src\BlendedConcept\Finance\Domain\Model\Entities\Plan;
use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Student\Domain\Model\Student;
use Src\BlendedConcept\Teacher\Domain\Model\Teacher;
use Src\Common\Domain\AggregateRoot;

class Organization extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $curr_subscription_id,
        public readonly ?string $org_admin_id,
        public readonly ?string $name,
        public readonly ?string $contact_name,
        public readonly ?string $contact_email,
        public readonly ?string $contact_number,
        public readonly ?string $sub_domain,
        public readonly ?string $logo,
        public readonly ?string $status,


    ) {
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
            'status' => $this->status ?? null,

        ];
    }
}
