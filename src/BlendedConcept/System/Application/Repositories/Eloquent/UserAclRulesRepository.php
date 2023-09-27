<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

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
     */
    public function getRules(): array
    {
        
        // if (auth()->user()->role->name == config('userrole.bcsuperadmin')) {
        //     return [
        //         ['disk' => 'local', 'path' => '*', 'access' => 2],
        //         ['disk' => 'avatars', 'path' => '*', 'access' => 2],
        //         ['disk' => 'local', 'path' => '*', 'access' => 2],
        //         ['disk' => 'media_user', 'path' => '*', 'access' => 2],
        //         ['disk' => 'media_organization', 'path' => '*', 'access' => 2],
        //     ];
        // }

        return [
            ['disk' => 'media_organization', 'path' => '*', 'access' => 2],
        ];
    }
}
