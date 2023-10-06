<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Commands;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Repositories\StoryBookRepositoryInterface;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;
use Src\Common\Domain\CommandInterface;

class UpdatePhysicalResourcesCommand implements CommandInterface
{
    private StoryBookRepositoryInterface $repository;

    public function __construct(
        private readonly Request $request,
        private readonly StoryBookEloquentModel $storybook,
    ) {
        $this->repository = app()->make(StoryBookRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updatePhysicalResource($this->request, $this->storybook);
    }
}
