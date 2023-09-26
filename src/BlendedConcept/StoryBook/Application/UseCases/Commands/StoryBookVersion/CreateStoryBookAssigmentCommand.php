<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StoryBookVersion;

use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookVersionRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class CreateStoryBookAssigmentCommand implements CommandInterface
{
    private StoryBookVersionRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(StoryBookVersionRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->assigmentAssigment();
    }
}
