<?php

namespace Src\BlendedConcept\Security\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfilePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'currentpassword' => ['required', 'string', 'min:8'],
            'updatedpassword' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'same:updatedpassword'],
        ];
    }
    
    public function messages()
    {
        return [
            'currentpassword.required' => "The current password field is required.",
            'updatedpassword.required' => "The updated password field is required.",
            'password_confirmation.required' => "The confirm password field is required.",
            'currentpassword.min' => "Password must be at least 8 characters.",
            'updatedpassword.min' => "Password must be at least 8 characters.",
            'password_confirmation.same' => "Confirm password must be same.",
        ];
    }
}
