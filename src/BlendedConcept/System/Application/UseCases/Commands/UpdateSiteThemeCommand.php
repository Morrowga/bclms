<?php

namespace Src\BlendedConcept\System\Application\UseCases\Commands;

use Src\BlendedConcept\System\Application\DTO\SiteSettingData;
use Src\BlendedConcept\System\Domain\Repositories\SettingRepositoryInterface;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\System\Application\DTO\SiteThemData;

class UpdateSiteThemeCommand implements CommandInterface
{
    private SettingRepositoryInterface $repository;

    public function __construct(
        private readonly SiteThemData $siteSettingData

    ) {
        $this->repository = app()->make(SettingRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateSiteTheme($this->siteSettingData);
    }
}
