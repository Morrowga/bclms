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
                'string',
            ],
            'game' => [
                'required'
            ],
            'thumb' => [
                'required'
            ],
            'disability_type_id' => [
                'required'
            ],
            'tags' => [
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Name is required',
            'description' => 'Description is required',
            'game' => 'Game file is required',
            'thumb' => 'Thumbnail image is required',
            'disability_type_id' => 'Disability Type is required',
            'tags' => 'Tag is required',
        ];
    }
}
