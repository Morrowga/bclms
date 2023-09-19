<?php

namespace Src\BlendedConcept\Security\Application\UseCases\Commands\UserProfile;

use Src\BlendedConcept\Security\Application\DTO\UserProfileData;
use Src\BlendedConcept\Security\Domain\Repositories\SecurityRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateUserProfileCommand implements CommandInterface
{
    private SecurityRepositoryInterface $repository;

    public function __construct(
        private readonly UserProfileData $userProfileData
    ) {
        $this->repository = app()->make(SecurityRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->updateUserProfile($this->userProfileData);
    }
}
