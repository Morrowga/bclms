<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Queries\BookReview;

use Src\BlendedConcept\StoryBook\Domain\Repositories\BookReviewRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetBookReview implements QueryInterface
{
    private BookReviewRepositoryInterface $repository;

    public function __construct(private readonly array $filters)
    {
        $this->repository = app()->make(BookReviewRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getBookReview($this->filters);
    }
}
