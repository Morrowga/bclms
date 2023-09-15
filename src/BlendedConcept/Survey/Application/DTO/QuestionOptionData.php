<?php

namespace Src\BlendedConcept\Survey\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Application\DTO\QuestionOptionData;

class QuestionOptionData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $question_id,
        public readonly string $content,

    ) {
    }

    public static function fromRequest(Request $request, $questionOption): QuestionOptionData
    {
        return new self(
            id: $questionOption->id,
            question_id: $request->question_id,
            content: $request->content,
        );
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
