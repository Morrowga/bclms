<?php

namespace Src\BlendedConcept\Organization\Domain\Services;

use Src\BlendedConcept\System\Application\Requests\StoreOrganizationRequest;
use Src\BlendedConcept\Organization\Application\Mappers\OrganizationMapper;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\StoreOrganizationCommand;
use Src\BlendedConcept\Organization\Application\DTO\OrganizationData;
use Src\BlendedConcept\System\Application\Requests\UpdateOrganizationRequest;
use Src\BlendedConcept\Organization\Application\UseCases\Commands\UpdateOrganizationCommand;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class OrganizationService
{


    public function createOrganization(StoreOrganizationRequest $request)
    {
        $newOrganizaton = OrganizationMapper::fromRequest($request);
        $saveOrganizaton = (new StoreOrganizationCommand($newOrganizaton));
        $saveOrganizaton->execute();
    }

    public function updateOrganization(UpdateOrganizationRequest $request, $organization_id)
    {
        $updateOrganization = OrganizationData::fromRequest($request, $organization_id);

        $updateOrganizationcommand = (new updateOrganizationCommand($updateOrganization));

        $updateOrganizationcommand->execute();
    }

    public function deleteOrganization($organization)
    {
       $organization->delete();
    }
}
