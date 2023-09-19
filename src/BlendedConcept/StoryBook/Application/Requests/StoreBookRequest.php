<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required', 'string', 'unique:storybooks,name',
            ],
            'description' => [
                'required', 'string',
            ],
            'num_gold_coins' => [
                'required',
            ],
            'num_silver_coins' => [
                'required',
            ],
            'is_free' => [
                'required',
            ],
            'tags' => [
                'required', 'array',
            ],
            'sub_learning_needs' => [
                'required', 'array',
            ],
            'themes' => [
                'required', 'array',
            ],
            'disability_type' => [
                'required', 'array',
            ],
            'devices' => [
                'required', 'array',
            ],
        ];
    }

    public function messages()
    {

    }
}
