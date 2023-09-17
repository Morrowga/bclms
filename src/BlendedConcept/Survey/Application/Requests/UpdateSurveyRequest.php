<?php

namespace Src\BlendedConcept\Survey\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSurveyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['string', 'required'],
            'description' => ['required', 'string'],
            'type' => [
                'required',
                Rule::in(['USERREXP', 'PROFILING'])
            ],
            'user_type' => ['required', 'string'],
            'appear_on' => ['required', 'string'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'required' => ['required', 'boolean'],
            'repeat' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'title' => 'Title is required',
            'description' => 'Description is required',
            'user_type' => 'User Type is required',
            'appear_on' => 'Appear on is required',
            'start_date' => 'Start Date on is required',
            'end_date' => 'End Date on is required',
        ];
    }
}
