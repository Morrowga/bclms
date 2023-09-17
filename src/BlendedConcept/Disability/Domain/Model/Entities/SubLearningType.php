<?php

namespace Src\BlendedConcept\Disability\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class SubLearningType extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $learning_needs_id,
        public readonly string $name,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'learning_need_id' => $this->learning_needs_id,
            'name' => $this->name,
        ];
    }
}
