<?php

namespace Src\BlendedConcept\Survey\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class QuestionOption extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $question_id,
        public readonly string $content,

    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'question_id' => $this->question_id,
            'content' => $this->content,
        ];
    }
}
