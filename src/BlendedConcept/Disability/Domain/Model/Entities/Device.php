<?php

namespace Src\BlendedConcept\Disability\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Device extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $status,
        public readonly ?array $disability_types,
        public readonly ?int $storybook_id
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'disability_types' => $this->disability_types,
            'storybook_id' => $this->storybook_id
        ];
    }
}
