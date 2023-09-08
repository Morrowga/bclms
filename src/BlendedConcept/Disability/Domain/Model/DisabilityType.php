<?php

namespace Src\BlendedConcept\Disability\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class DisabilityType extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}
