<?php

namespace Src\BlendedConcept\Organisation\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganisationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'name' => [
                'string',
                'required',
            ],
            'contact_email' => [
                'required',
                'email',
                'unique:organisations,contact_email',
            ],
            'contact_number' => [
                'required',
                'max:8'
            ],
            'org_admin_name' => [
                'required',
            ],
            'org_admin_contact_number' => [
                'required',
                'max:8'
            ],
            'login_email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'login_password' => [
                'required', 'min:8',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name' => 'This organisation name already exist',
            'org_admin_contact_number.max' => 'This organisation contact number maximum 8.',
            'contact_number.max' => 'This organisation contact number maximum 8.',
            'login_password.min' => 'Password length must be at least 8 characters'
        ];
    }
}
