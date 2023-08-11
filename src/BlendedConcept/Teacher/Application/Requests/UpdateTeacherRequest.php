<?php

namespace Src\BlendedConcept\Teacher\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => ['required', 'not_in:Select'],
            'name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required'],
            'email' => ['required', 'email',  'unique:users,email,'.request()->route('teacher')->id],
        ];
    }
}
