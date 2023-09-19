<?php

namespace Src\BlendedConcept\Security\Application\Policies;

class UserProfilePolicy
{
    public static function view()
    {
        return auth()->user()->hasPermission('access_user_profile');
    }

    public static function update()
    {
        return auth()->user()->hasPermission('edit_user_profile');
    }
}
