<?php

namespace Src\BlendedConcept\User\Domain\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => ['required','string'],
            'name' => ['required'],
            'dob'  => ['required'],
            'contact_number' => ['required'],
            'email' => ['required','email',  'unique:users,email,' . request()->route('user')->id],
        ];
    }
}
