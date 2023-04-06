<?php

namespace Src\BlendedConcept\User\Domain\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest  extends FormRequest
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
            'nickname' => [
                'string',
                'required'
            ],
            'dob' => [
                'required'
            ],
            'grade' => [
                'required'
            ]

        ];
    }
}