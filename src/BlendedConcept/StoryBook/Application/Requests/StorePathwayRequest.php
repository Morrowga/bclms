<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePathwayRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => ['required'],
            "description" => ['required'],
            "num_gold_coins" => ['required'],
            "num_silver_coins" => ['required'],
            "need_complete_in_order" => ['required']
        ];
    }
}
