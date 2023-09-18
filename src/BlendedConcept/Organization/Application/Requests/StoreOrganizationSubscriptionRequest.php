<?php

namespace Src\BlendedConcept\Organization\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationSubscriptionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'start_date' => [
                'required',
            ],
            'end_date' => [
                'required',
            ],
            'stripe_price' => [
                'required',
            ],
            'payment_date' => [
                'required',
            ],
            'b2b_subscription' => [
                'required',
            ],
        ];
    }
}
