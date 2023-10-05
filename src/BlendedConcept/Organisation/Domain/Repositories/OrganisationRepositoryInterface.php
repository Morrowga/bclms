<?php

namespace Src\BlendedConcept\Organisation\Domain\Repositories;

use Src\BlendedConcept\FInance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Organisation\Application\DTO\OrganisationData;
use Src\BlendedConcept\Organisation\Domain\Model\Entities\OrganisationAdmin;
use Src\BlendedConcept\Organisation\Domain\Model\Organisation;

interface OrganisationRepositoryInterface
{
    public function getOrganisationNameId();

    public function getOrganisations($filers);

    public function createOrganisation(Organisation $organisation, OrganisationAdmin $organisationAdmin);

    public function updateOrganisation(OrganisationData $organisationData);

    public function getOrganisationNameWithCount();

    public function addOrganisationSubscription(SubscriptionData $subscriptionData);

    public function newOrganisationSubscription(Subscription $subscription);

}
