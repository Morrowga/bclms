<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => [
                'required',
            ],
            'game_id' => [
                'required',
            ],
            'score' => [
                'nullable',
            ],
            'accuracy' => [
                'nullable',
            ],
            'duration' => [
                'nullable',
            ],
        ];
    }
}
