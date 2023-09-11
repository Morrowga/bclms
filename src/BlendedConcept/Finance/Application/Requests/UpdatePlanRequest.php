<?php

namespace Src\BlendedConcept\Finance\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string', 'required'],
            'storage_limit' => ['required'],
            'num_student_license' => ['required'],
            'price' => ['required'],
            'storage_limit' => ['required']
        ];
    }
}
