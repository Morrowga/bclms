<?php

namespace Src\BlendedConcept\Library\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Library extends AggregateRoot implements \JsonSerializable
{
    public function __construct(
        // TODO Add properties
    ) {
    }

    public function toArray(): array
    {
        return [
            // TODO Add properties
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
