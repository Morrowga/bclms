<?php

namespace Src\BlendedConcept\Security\Domain\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => ['required', 'not_in:Select'],
            'name' => ['required'],
            'contact_number' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8']
        ];
    }
}
