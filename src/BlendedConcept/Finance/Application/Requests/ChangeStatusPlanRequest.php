<?php

namespace Src\BlendedConcept\Finance\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusPlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "status" => ['required']
        ];
    }
}
