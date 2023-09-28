<?php

namespace Src\BlendedConcept\Organisation\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganisationRequest extends FormRequest
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
                'unique:organisations,contact_email,' . request()->route('organisation')->id,
            ],
            'org_admin_name' => [
                'required',
            ],
            'org_admin_contact_number' => [

                'required',
            ],
            'login_email' => [
                'required',
                'email',
                // 'unique:users,email,' . request()->route('organisation')->user->org_admin_id,
            ],
        ];
    }
}
