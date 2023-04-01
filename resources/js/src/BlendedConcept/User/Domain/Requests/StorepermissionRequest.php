<?php

namespace Src\BlendedConcept\User\Domain\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StorepermissionRequest  extends FormRequest
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
        ];
    }
}
