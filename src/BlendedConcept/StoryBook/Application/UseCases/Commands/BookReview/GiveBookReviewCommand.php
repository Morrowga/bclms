<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\BookReview;

use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Review;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookVersionRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class GiveBookReviewCommand implements CommandInterface
{
    private StoryBookVersionRepositoryInterface $repository;

    public function __construct(
        private readonly Review $review
    ) {
        $this->repository = app()->make(StoryBookVersionRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->bookreview($this->review);
    }
}
