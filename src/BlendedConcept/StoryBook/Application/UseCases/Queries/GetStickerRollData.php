<?php

namespace Src\BlendedConcept\StoryBook\Application\UseCases\Queries;

use Src\BlendedConcept\StoryBook\Domain\Repositories\RewaredRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetStickerRollData implements QueryInterface
{
    private RewaredRepositoryInterface $repository;

    public function __construct(
        private readonly int $count
    ) {
        $this->repository = app()->make(RewaredRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getStickerRollData($this->count);
    }
}
