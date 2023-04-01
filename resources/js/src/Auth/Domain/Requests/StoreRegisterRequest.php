<?php

namespace Src\Auth\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest  extends FormRequest
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
                'unique:users,email'
            ],
            'password' => [
                'required',
                'min:8'
            ]
        ];
    }
}
