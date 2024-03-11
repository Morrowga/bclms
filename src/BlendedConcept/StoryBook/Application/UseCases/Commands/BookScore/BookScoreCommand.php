<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\BookScore;

use Illuminate\Http\Request;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;

class BookScoreCommand implements CommandInterface
{
    private StoryBookRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request,
    ) {
        $this->repository = app()->make(StoryBookRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->bookScore($this->request);
    }
}
