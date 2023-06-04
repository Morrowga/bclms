<?php

namespace Src\BlendedConcept\Organization\Domain\Model;

use Src\BlendedConcept\Organization\Domain\Model\Entities\Plan;
use Src\Common\Domain\AggregateRoot;

class Organization extends AggregateRoot implements \JsonSerializable
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $plan_id,
        public readonly ?string $name,
        public readonly ?string $description,
        public readonly ?string $type,
        public readonly ?string $contact_person,
        public readonly ?string $contact_email,
        public readonly ?string $contact_number,
        public readonly Plan $plan,
    ) {
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'plan_id' => $this->plan_id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'contact_person' => $this->contact_person,
            'contact_email' => $this->contact_email,
            'contact_number' => $this->contact_number,
            'plan' => $this->plan
        ];
    }
}
