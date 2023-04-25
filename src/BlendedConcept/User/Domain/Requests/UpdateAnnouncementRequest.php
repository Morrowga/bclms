<?php

namespace Src\BlendedConcept\User\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'unique:permissions,name',
                'required',
            ],
        ];
    }
}
