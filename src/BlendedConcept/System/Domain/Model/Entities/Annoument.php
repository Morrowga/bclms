<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Domain\Model\Entities;
use Src\Common\Domain\Entity;

class Annoument extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $message,
        public readonly ?int $created_by,
        public readonly ?int $trigger_on,
        public readonly ?int $send_to,
    ) {}



    public function toArray(): array
    {
        return [

            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'created_by' => $this->created_by,
            'trigger_on' => $this->trigger_on,
            'send_to' => $this->send_to
        ];
    }
}
