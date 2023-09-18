<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRewardRequest extends FormRequest
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
            'gold_coins_needed' => [
                'required', 'numeric',
            ],
            'silver_coins_needed' => [
                'required', 'numeric',
            ],
            'rarity' => [
                'required', 'not_in:SELECT',
            ],
        ];
    }

    public function messages()
    {
        return [
            'rarity' => 'Please select rarity',
        ];
    }
}
