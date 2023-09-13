<?php

namespace Src\BlendedConcept\System\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateSiteThemeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'skins' => [
            'required'
        ],
        'themes' => [
            'required'
        ],
        'primary_color' => [
            'required'
        ],
        'secondary_color' => [
            'required'
        ],
        'content_with' => [
            'required'
        ],
        'header_type' => [
            'required'
        ],
        'footer_type' => [
            'required'
        ],
        'menu_type' => [
            'required'
        ],
        ];
    }
}
