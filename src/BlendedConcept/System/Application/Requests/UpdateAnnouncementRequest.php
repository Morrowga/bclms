<?php

namespace Src\BlendedConcept\System\Application\Requests;

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
                'required',
                'string',
            ],
            'message' => [
                'required',
                'string'
            ],
            'created_by' => [
                "required"
            ],
            'send_to' => [
                'required'
            ],
            'type' => [
                'required'
            ],
        ];
    }
}
