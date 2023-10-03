<?php

namespace Src\BlendedConcept\Library\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filename' => [
                'required',
            ],
            // 'file' => [
            //     'required',
            // ],
        ];
    }

    public function messages()
    {
        return [
            'filename' => 'Filename is required',
            'file' => 'File is required',
        ];
    }
}
