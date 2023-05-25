<?php

namespace Src\BlendedConcept\System\Application\UseCases\Queries;

use Src\BlendedConcept\System\Domain\Repositories\SettingRepositoryInterface;
use Src\Common\Domain\QueryInterface;

class GetSiteSetting implements QueryInterface
{
    private SettingRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = app()->make(SettingRepositoryInterface::class);
    }

    public function handle()
    {
        return $this->repository->getSetting();
    }
}
