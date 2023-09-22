<?php

namespace Src\BlendedConcept\Disability\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetDeviceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'device_id' => ['required'],
        ];
    }
}
