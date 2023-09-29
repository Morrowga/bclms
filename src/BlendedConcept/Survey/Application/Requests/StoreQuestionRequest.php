<?php

namespace Src\BlendedConcept\Survey\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'survey_id' => ['required'],
            'question_type' => [
                'required',
                Rule::in(['SINGLE_CHOICE', 'MULTIPLE_RESPONSE', 'RATING', 'SHORT_ANSWER']),
            ],
            'question' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'question_type' => 'Question Type is required',
            'question' => 'Question is required',
            'options' => 'Options is required',
        ];
    }
}
