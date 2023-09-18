<?php

namespace Src\BlendedConcept\Survey\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends FormRequest
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
                Rule::in(['SINGLE_CHOICE', 'MULTIPLE_RESPONSE', 'RATING']),
            ],
            'question' => ['required', 'string'],
            'options' => ['required', 'string'],
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
