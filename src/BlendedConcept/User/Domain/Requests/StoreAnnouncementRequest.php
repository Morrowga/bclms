<?php

namespace Src\BlendedConcept\User\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest  extends FormRequest
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
