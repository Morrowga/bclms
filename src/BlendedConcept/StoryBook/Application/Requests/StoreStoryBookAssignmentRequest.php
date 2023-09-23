<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoryBookAssignmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'storybook_version_id' => ['required'],
            'student_ids' => ['array','required']
        ];
    }

    public function messages()
    {
        return [
            'storybook_version_id' => "Story Version is required",
            'student_ids' => "Select Students"
        ];
    }
}
