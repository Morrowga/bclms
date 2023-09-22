<?php

namespace Src\BlendedConcept\Student\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaylistRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'student_id' => [
                'required',
            ],
            'storybooks' => [
                'required',
            ],
        ];
    }
}
