<?php

namespace Src\BlendedConcept\Security\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class User extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly ?string $password,
        public readonly ?string $email_verification_send_on,
        public readonly string $contact_number,
        public readonly string $status,
        public readonly string $profile_pic,
    ) {
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "password" => $this->password,
            "email_verification_send_on" => $this->email_verification_send_on,
            "contact_number" => $this->contact_number,
            "status" => $this->status,
            "profile_pic" => $this->profile_pic,
        ];
    }
}
