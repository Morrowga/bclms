<?php

namespace Src\BlendedConcept\StoryBook\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoryBookReview extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'storybook_id' => 'required',
            'stars' => 'required',
            'feedback' => 'required',
        ];
    }

    public function messages()
    {
        return [
            "storybook_id" =>"StoryBook is required",
            "stars" => "",
            "feedback" => "You need to give some feedbacks"
        ];
    }
}
