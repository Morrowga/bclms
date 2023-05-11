<?php

namespace Src\BlendedConcept\Organization\Application\Repositories\Eloquent;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use Illuminate\Support\Facades\Auth;

class UserAclRulesRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {
        if (Auth::id() === 1) {
            return [
                ['disk' => 'local', 'path' => '*', 'access' => 2],
            ];
        }

        return [
            ['disk' => 'avatars', 'path' => '*', 'access' => 0],
            ['disk' => 'local', 'path' => '*', 'access' => 0],
            ['disk' => 'media_userrs', 'path' => '*', 'access' => 0],
            ['disk' => 'media_organization', 'path' => '*', 'access' => 2]
        ];
    }
}


