<?php

namespace Src\Auth\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                // 'email',
            ],
            'password' => [
                'required',
            ],
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Enter your email or username address',
            'password.required' => 'Enter your password'

        ];
    }
}
