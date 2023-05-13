<?php

namespace Src\BlendedConcept\Organization\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest  extends FormRequest
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
                'required'
            ],
            'contact_email' => [
                'required',
                'email',
                'unique:organizations,contact_email,' . request()->route('organization')->id
            ],
        ];
    }
}
