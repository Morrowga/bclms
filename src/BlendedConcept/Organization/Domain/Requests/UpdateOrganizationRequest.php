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
                'required',
            ],
        ];
    }
}
