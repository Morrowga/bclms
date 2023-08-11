<?php

namespace Src\BlendedConcept\Teacher\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Teacher extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?int $organization_id,
        public readonly ?string $email_verified_at,
        public readonly ?string $dob,
        public readonly ?string $contact_number,
        public readonly ?int $storage_limit,
        public readonly string $password,
        public readonly ?string $is_active,
        public readonly ?int $stripe_id,
        public readonly ?string $pm_brand,
        public readonly ?string $pm_last_four,
        public readonly ?string $trial_end_at,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'organization_id' => $this->organization_id,
            'email_verified_at' => $this->email_verified_at,
            'dob' => $this->dob,
            'contact_number' => $this->contact_number,
            'storage_limit' => $this->storage_limit,
            'password' => $this->password,
            'is_active' => $this->is_active,
            'stripe_id' => $this->stripe_id,
            'pm_brand' => $this->pm_brand,
            'pm_last_four' => $this->pm_last_four,
            'trial_end_at' => $this->trial_end_at,
        ];
    }
}
