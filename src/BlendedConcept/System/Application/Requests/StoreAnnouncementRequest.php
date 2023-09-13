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
}
