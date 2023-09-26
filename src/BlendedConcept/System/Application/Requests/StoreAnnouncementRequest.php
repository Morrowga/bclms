<?php

namespace Src\BlendedConcept\System\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
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
            ],
            'message' => [
                'required',
            ],
            'icon' => [
                'required',
            ],
            'by' => [
                'required',
            ],
            'to' => [
                'required',
            ],
            'org' => [
                'required',
            ],
            'users' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'title' => 'Title is required',
            'message' => 'Message is required',
            'icon' => 'Icon is required',
            'to' => 'Announment to is required',
        ];
    }
}
