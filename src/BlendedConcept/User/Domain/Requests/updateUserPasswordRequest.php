<?php

namespace Src\BlendedConcept\User\Domain\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'currentpassword' => [

                'min:8',
                'required',
            ],
            'updatedpassword' => [
                'required',
                'min:8'
            ]
        ];
    }
}
