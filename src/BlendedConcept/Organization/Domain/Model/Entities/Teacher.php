<?php

namespace Src\BlendedConcept\Organization\Domain\Model\Entities;

use Src\Common\Domain\Entity;


class Teacher extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly ?string $contact_number,
        public readonly ?string $email_verification_send_on,
        public readonly ?int $role_id,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'email_verification_send_on' => $this->email_verification_send_on,
            'role_id' => $this->role_id,
        ];
    }
}
