<?php

namespace Src\BlendedConcept\Survey\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Response extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $user_id,
        public readonly int $question_id,
        public readonly ?int $student_id,
        public readonly string $answer,
        public readonly string $response_datetime,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'question_id' => $this->question_id,
            'student_id' => $this->student_id,
            'answer' => $this->answer,
            'response_datetime' => $this->response_datetime,
        ];
    }
}