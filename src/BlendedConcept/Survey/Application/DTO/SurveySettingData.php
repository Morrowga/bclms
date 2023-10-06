<?php

namespace Src\BlendedConcept\Survey\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Survey\Application\DTO\SurveySettingData;

class SurveySettingData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $survey_id,
        public readonly string $user_type,

    ) {
    }

    public static function fromRequest(Request $request, $survey): SurveySettingData
    {
        return new self(
            id: $survey->id,
            survey_id: $request->survey_id,
            user_type: $request->user_type,
        );
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
