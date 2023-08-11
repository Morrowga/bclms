<?php

namespace Src\BlendedConcept\Student\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateStudentRequest extends FormRequest
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
