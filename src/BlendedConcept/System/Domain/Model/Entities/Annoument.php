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
        public readonly ?int $target_role_id,
        public readonly ?int $author_id,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $this->icon,
            'message' => $this->message,
            'target_role_id' => $this->target_role_id,
            'author_id' => $this->author_id,
        ];
    }
}
