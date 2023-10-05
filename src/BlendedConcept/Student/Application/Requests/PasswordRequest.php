<?php

namespace Src\BlendedConcept\Student\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Common\Application\Rules\PasswordHashCheck;

class PasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => [
                'required',
                new PasswordHashCheck,
            ],
            'student_id' => [
                'required',
            ],
        ];
    }


    public function messages()
    {
        return [
            'password.required' => 'Password is required',
            'password_hash_check' => 'Incorrect password. Please try again.',
        ];
    }
}
