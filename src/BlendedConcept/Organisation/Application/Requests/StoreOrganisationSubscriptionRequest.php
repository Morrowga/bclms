<?php

namespace Src\BlendedConcept\Organisation\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

class StoreOrganisationSubscriptionRequest extends FormRequest
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
            'isExpire' => [
                $this->checkExpireOrNot() ? 'required' : 'nullable'
            ]
        ];
    }


    public function messages()
    {
        return [
            'isExpire' => "Organisation's subscription still active.",
        ];
    }

    public function checkExpireOrNot(){
        $id = request()->id;

        $organisation = OrganisationEloquentModel::find($id);
        $today = now()->format('Y-m-d'); // Get the current date and format it as 'YYYY-MM-DD'
        $subscription = $organisation->subscription;
        if($subscription == null) {
            return false;
        }
        $start_date = $subscription->start_date;
        $end_date = $subscription->end_date;

        if ($today >= $start_date && $today <= $end_date) {
            return true;
        } else {
            return false;
        }
    }
}
