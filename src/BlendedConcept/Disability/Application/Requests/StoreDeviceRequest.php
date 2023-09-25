<?php

namespace Src\BlendedConcept\Disability\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            // 'description' => ['required'],
        ];
    }
}
