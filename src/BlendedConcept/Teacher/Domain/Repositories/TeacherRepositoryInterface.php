<?php

namespace Src\BlendedConcept\Teacher\Domain\Repositories;

use Src\BlendedConcept\Security\Domain\Model\User;
use Src\BlendedConcept\Security\Application\DTO\UserData;

interface TeacherRepositoryInterface
{
    public function getUsers($filters = []);
    public function createUser(User $user);
    public function updateUser(UserData $user);
}
