<?php

namespace Src\BlendedConcept\Finance\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateB2bSubscriptionRequest extends FormRequest
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
            'b2b_subscription' => ['required'],
        ];
    }
}
