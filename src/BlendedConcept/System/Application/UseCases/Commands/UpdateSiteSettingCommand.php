<?php

namespace Src\BlendedConcept\System\Application\UseCases\Commands;


use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\System\Application\DTO\SiteSettingData;
use Src\BlendedConcept\System\Domain\Repositories\SettingRepositoryInterface;

class UpdateSiteSettingCommand implements CommandInterface
{
    private SettingRepositoryInterface $repository;

    public function __construct(
        private readonly SiteSettingData $siteSettingData

    )
    {
        $this->repository = app()->make(SettingRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateSetting($this->siteSettingData);
    }
}