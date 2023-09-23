<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoryBookVersion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'storybook_id' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
        ];
    }
}
