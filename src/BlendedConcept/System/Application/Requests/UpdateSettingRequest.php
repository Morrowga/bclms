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
            'site_time_zone' => [
                'required',
            ],
            'site_locale' => [
                'required',
            ],
            'email' => [
                'required',
            ],
            'contact_number' => [
                'required', 'numeric',
            ],
            'url' => [
                'required',
            ],
        ];
    }
}
