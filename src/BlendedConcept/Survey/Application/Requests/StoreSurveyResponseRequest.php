<?php

namespace Src\BlendedConcept\Survey\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSurveyResponseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'results' => ['required'],
            'survey_id' => ['required'],
            'user_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'results' => 'Result is required',
        ];
    }
}
