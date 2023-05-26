<?php

namespace Src\BlendedConcept\Security\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Role extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
    ) {}



    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
