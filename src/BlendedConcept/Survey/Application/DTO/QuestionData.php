<?php

namespace Src\BlendedConcept\Survey\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Application\DTO\QuestionData;

class QuestionData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $survey_id,
        public readonly string $question_type,
        public readonly string $question,

    ) {
    }

    public static function fromRequest(Request $request, $question): QuestionData
    {
        return new self(
            id: $question->id,
            survey_id: $request->survey_id,
            question_type: $request->question_type,
            question: $request->question,
        );
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
