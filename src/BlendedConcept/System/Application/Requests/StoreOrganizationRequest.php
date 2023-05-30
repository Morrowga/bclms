<?php

namespace Src\BlendedConcept\System\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string','required'],
            'contact_email' => ['required', 'email', 'unique:organizations,contact_email'],
        ];
    }
}
