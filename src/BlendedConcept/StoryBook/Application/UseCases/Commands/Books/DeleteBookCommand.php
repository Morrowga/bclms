<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\Books;

use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Review;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\Common\Domain\CommandInterface;

class DeleteBookCommand implements CommandInterface
{
    private StoryBookRepositoryInterface $repository;

    public function __construct(
        private readonly StoryBookEloquentModel $book
    ) {
        $this->repository = app()->make(StoryBookRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteBook($this->book);
    }
}
