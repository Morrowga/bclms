<?php

namespace Src\BlendedConcept\StoryBook\Domain\Repositories;

interface BookReviewRepositoryInterface
{
    //get game lists
    public function getBookReview($filters);
}
