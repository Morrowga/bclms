<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required', 'string',
            ],
            'description' => [
                'required', 'string'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Name is required',
            'description' => 'Description is required',
        ];
    }
}
