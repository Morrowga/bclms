<?php

namespace Src\BlendedConcept\ClassRoom\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeClassRoomRequest extends FormRequest
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
            'gold_coins' => [
                'required', 'numeric',
            ],
            'silver_coins' => [
                'required', 'numeric',
            ],
            'rarity' => [
                'required', 'string',
            ],
        ];
    }
}
