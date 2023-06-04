<?php

namespace Src\BlendedConcept\Teacher\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest  extends FormRequest
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
