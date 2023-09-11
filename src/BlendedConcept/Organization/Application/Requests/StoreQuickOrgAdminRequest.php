<?php

namespace Src\BlendedConcept\Organization\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuickOrgAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'org_admin_name' => [
                'required',
            ],
            'org_admin_contact_number' => [

                'required',
            ],
            'login_email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'login_password' => [
                'required',
                'min:8'
            ]
        ];
    }
}
