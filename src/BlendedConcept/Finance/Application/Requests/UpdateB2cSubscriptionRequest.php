<?php

namespace Src\BlendedConcept\Finance\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateB2cSubscriptionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => ['required'],
            'end_date' => ['required'],
            'user_id' => ['required'],
            'plan_id' => ['required']
        ];
    }
}
