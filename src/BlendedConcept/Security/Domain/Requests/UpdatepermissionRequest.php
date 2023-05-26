<?php

namespace Src\BlendedConcept\Security\Domain\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdatepermissionRequest  extends FormRequest
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
                'unique:permissions,name',
                'required',
            ],
        ];
    }
}
