<?php

use Illuminate\Support\Facades\Cache;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;

//Notification Helper to Vue Component
if (!function_exists('getNotifications')) {
    function getNotifications()
    {
        $notification = Cache::remember('unread_notifications_' . auth()->id(), 60, function () {
            return auth()->user()
                ? auth()->user()->unreadNotifications()
                ->whereJsonDoesntContain('data->type', 'HomeAnnounce')
                ->with('notifiable')
                ->paginate(7)
                : null;
        });

        $notification = $notification
            ? ['notifications' => $notification, 'unread' => $notification->total()]
            : null;

        return $notification;
    }
}

//Remove null in array
if (!function_exists('removeNullInArray')) {
    function removeNullInArray($array)
    {
        $filteredArray = array_filter($array, function ($value) {
            return $value !== null;
        });

        return $filteredArray;
    }
}

//this is global function that check which user has access

if (!function_exists('authorize')) {
    /* @throws UnauthorizedUserException */
    function authorize($ability, $policy, $arguments = []): bool
    {
        if ($policy::{$ability}(...$arguments)) {
            return false;
        }

        return true;
    }
}

/****
 *  get disk space according to disk array
 */

if (!function_exists('getFileSystemWithRole')) {
    function getFileSystemWithRole($userrole)
    {
        try {
            if ($userrole == config('userrole.bcsuperadmin')) {
                return ['local', 'avatars', 'media_user', 'media_organisation'];
            } elseif ($userrole == config('userrole.organisation_admin')) {
                return ['media_students', 'media_teachers'];
            } elseif ($userrole == config('userrole.teacher')) {
                return ['media_teachers'];
            } else {
                return ['local', 'avatars', 'media_user', 'media_organisation'];
            }
        } catch (\Exception $error) {

            return ['local'];
        }
    }
}

if (!function_exists('isEvenOdd')) {
    function isEvenOdd($number)
    {
        if ($number % 2 == 0) {
            return 'even';
        } else {
            return 'odd';
        }
    }
}
