<?php

namespace Src\Auth\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'email',
                'required',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
            'first_name' => [
                'required'
            ],
            'last_name' => [
                'required'
            ],
            'contact_number' => [
                'required'
            ],
            'email' => [
                'required'
            ]
        ];
    }
}
