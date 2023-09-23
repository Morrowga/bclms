<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoryBookVersion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'storybook_id' => ['required'],
            'teacher_id' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
        ];
    }
}
