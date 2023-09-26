<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRewardRequest extends FormRequest
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
            'name' => 'Name field is required',
            'description' => 'Description field is required',
            'gold_coins_needed' => 'Gold Coins Need is required',
            'silver_coins_needed' => 'Silver Coins Need is required',
            'rarity.not_in' => 'Please select rarity',
        ];
    }
}
