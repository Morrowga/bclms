<?php

namespace Src\BlendedConcept\Student\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'gender.required' => 'Please select a gender',
    //         'dob' => 'Enter your date of birth',
    //         'education_level' => 'Enter your education level',
    //         'contact_number.required' => 'Enter a parent contact number',
    //         'contact_number.unique' => 'This phone number is already in use',
    //         'email.required' => 'Enter your email address',
    //         'email.email' => 'Enter a valid email address',
    //         'email.unique' => 'This email is already in use',
    //     ];
    // }
}
