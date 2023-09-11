<?php

namespace Src\BlendedConcept\System\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionTechnicalSupportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required', 'integer',
            ],
            'question' => [
                'required', 'string',
            ],
        ];
    }
}
