<?php

namespace Src\BlendedConcept\Survey\Application\DTO;

use Illuminate\Http\Request;

class SurveyData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $type,
        public readonly string $user_type,
        public readonly string $appear_on,
        public readonly string $start_date,
        public readonly string $end_date,
        public readonly bool $required,
        public readonly bool $repeat,

    ) {
    }

    public static function fromRequest(Request $request, $survey): SurveyData
    {
        return new self(
            id: $survey->id,
            title: $request->title,
            description: $request->description,
            type: $request->type,
            user_type: $request->user_type,
            appear_on: $request->appear_on,
            start_date: $request->start_date,
            end_date: $request->end_date,
            required: $request->required,
            repeat: $request->repeat,

        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'user_type' => $this->user_type,
            'appear_on' => $this->appear_on,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'requried' => $this->required,
            'repeat' => $this->repeat,
        ];
    }
}
