<?php

namespace Src\BlendedConcept\Survey\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class SurveySetting extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $survey_id,
        public readonly string $user_type,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'survey_id' => $this->survey_id,
            'user_type' => $this->user_type,
        ];
    }
}
