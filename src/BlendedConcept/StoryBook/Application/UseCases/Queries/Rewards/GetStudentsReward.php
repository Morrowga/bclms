<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Queries\Rewards;

use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStudentsReward implements QueryInterface
{
    private RewaredRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(RewaredRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStudentsReward();
    }
}
