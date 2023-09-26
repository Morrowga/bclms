<?php

namespace Src\BlendedConcept\Student\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilingSubmitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'survey_id' => [
                'required',
            ],
            'student_id' => [
                'required',
            ],
            'user_id' => [
                'required',
            ],
            'response_datetime' => [
                'required',
            ],
        ];
    }
}
