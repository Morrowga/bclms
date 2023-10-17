<?php

namespace Src\BlendedConcept\Teacher\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherStorage extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "storage" => ['required']
        ];
    }
}
