<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class TechnicalSupport extends Entity
{
    public function __construct(

        public readonly ?int $id,
        public readonly int $user_id,
        public readonly string $date,
        public readonly string $has_responsed,
        public readonly string $question,
        public readonly ?string $response,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'has_responsed' => $this->has_responsed,
            'question' => $this->question,
            'response' => $this->response,
        ];
    }
}
