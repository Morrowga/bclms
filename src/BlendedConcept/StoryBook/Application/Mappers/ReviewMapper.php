<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Review;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\ReviewEloquentModel;

class ReviewMapper
{
    public static function fromRequest(Request $request, $review_id = null): Review
    {
        return new Review(
            id : $review_id,
            given_by_user_id : $request->given_by_user_id,
            storybook_id : $request->storybook_id,
            stars : $request->stars,
            feedback : $request->feedback,
            given_on : $request->given_on,
        );
    }

    public static function toEloquent(Review $review): ReviewEloquentModel
    {
        $reviewEloquent = new ReviewEloquentModel();

        if ($review->id) {
            $reviewEloquent = ReviewEloquentModel::query()->findOrFail($review->id);
        }
        $reviewEloquent->id = $review->id;
        $reviewEloquent->given_by_user_id = $review->given_by_user_id;
        $reviewEloquent->storybook_id = $review->storybook_id;
        $reviewEloquent->stars = $review->stars;
        $reviewEloquent->feedback = $review->feedback;
        $reviewEloquent->given_on = $review->given_on;

        return $reviewEloquent;
    }
}
