<?php

namespace Src\BlendedConcept\ClassRoom\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeClassRoomRequest  extends FormRequest
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
                'unique:permissions,name',
                'required',
            ],
        ];
    }
}
