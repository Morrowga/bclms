<?php

namespace Src\BlendedConcept\Disability\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class LearningNeed extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,

    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
