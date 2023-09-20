<?php

namespace Src\BlendedConcept\Organization\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
            'email' => [
                'required',
            ],
            'contact_number' => [
                'required',
            ],
            'image' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Name is required',
            'email' => 'Email is required',
            'contact_number' => 'Contact Number is required',
        ];
    }
}
