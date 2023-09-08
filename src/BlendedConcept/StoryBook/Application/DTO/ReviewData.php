<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\DTO\ReviewData;

class ReviewData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $given_by_user_id,
        public readonly int $storybook_id,
        public readonly int $stars,
        public readonly string $feedback,
        public readonly string $given_on,
    ) {
    }

    public static function fromRequest(Request $request, $review_id): ReviewData
    {
        return new self(
            id : $review_id,
            given_by_user_id : $this->given_by_user_id,
            storybook_id : $this->storybook_id,
            stars : $this->stars,
            feedback : $this->feedback,
            given_on : $this->given_on,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'given_by_user_id' => $this->given_by_user_id,
            'storybook_id' => $this->storybook_id,
            'stars' => $this->stars,
            'feedback' => $this->feedback,
            'given_on' => $this->given_on,
        ];
    }
}
