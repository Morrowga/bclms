<?php

namespace Src\BlendedConcept\Security\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class ParentUser extends Entity
{
    public function __construct(
        public readonly ?int $parent_id,
        public readonly int $user_id,
        public readonly ?int $organisation_id,
        public readonly ?int $curr_subscription_id,
        public readonly string $type
    ) {
    }

    public function toArray(): array
    {
        return [
            'parent_id' => $this->parent_id,
            'user_id' => $this->user_id,
            'organisation_id' => $this->organisation_id,
            'curr_subscription_id' => $this->curr_subscription_id,
            'type' => $this->type
        ];
    }
}
