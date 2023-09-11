<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Annoument extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $icon,
        public readonly string $message,
        public readonly string $by,
        public readonly string $to,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $this->icon,
            'message' => $this->message,
            'by' => $this->by,
            'to' => $this->to,
        ];
    }
}
