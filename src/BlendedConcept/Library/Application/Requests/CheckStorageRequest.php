<?php

namespace Src\BlendedConcept\Library\Application\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Src\BlendedConcept\Library\Application\Rules\OrgStorageCheck;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

class CheckStorageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' =>[
                'required'
            ],
            'size' => [
                new OrgStorageCheck(),
            ],
        ];
    }
}
