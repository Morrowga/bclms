<?php

namespace Src\BlendedConcept\Survey\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Question extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $survey_id,
        public readonly string $question_type,
        public readonly string $question,

    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'survey_id' => $this->survey_id,
            'question_type' => $this->question_type,
            'question' => $this->question,
        ];
    }
}
