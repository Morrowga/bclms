<?php

namespace Src\BlendedConcept\Security\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required'],
            'email' => ['required', 'email',  'unique:users,email,'.auth()->user()->id],
        ];
    }
    
    public function messages()
    {
        return [
            'first_name.required' => "The first name field is required.",
            'last_name.required' => "The last name field is required.",
            'contact_number.required' => "The contact number field is required.",
            'email.required' => "The email field is required.",
            'email.unique' => "The email field must be unique",
        ];
    }
}
