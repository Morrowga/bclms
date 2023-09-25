<?php

namespace Src\BlendedConcept\StoryBook\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\ReviewEloquentModel;
use Src\BlendedConcept\StoryBook\Domain\Resources\BoookReviewResource;
use Src\BlendedConcept\StoryBook\Domain\Repositories\BookReviewRepositoryInterface;

class BookReviewRepository implements BookReviewRepositoryInterface
{

    public function getBookReview($filters)
    {

        $bookReview = BoookReviewResource::collection(ReviewEloquentModel::filter($filters)
        ->with(['storybooks','users'])
        ->orderBy('id', 'desc')
        ->paginate($filters['perPage'] ?? 10));

        return $bookReview;
    }

}









