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
                'string',
            ],
            'message' => [
                'required',
                'string',
            ],
            'author_id' => [
                'required',
            ],
            'target_role_id' => [
                'required',
            ],
        ];
    }
}
