<?php

namespace Src\BlendedConcept\System\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'site_name' => [
                'required',
            ],
            'timezone' => [
                'required',
            ],
            'locale' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
            ],
            'contact_number' => [
                'required',
            ],
        ];
    }
}
