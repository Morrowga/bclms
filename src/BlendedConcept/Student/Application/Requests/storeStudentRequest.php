<?php

namespace Src\BlendedConcept\Student\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeStudentRequest  extends FormRequest
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
