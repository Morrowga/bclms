<?php

//Notification Helper to Vue Component
if (!function_exists('getNotifications')) {
    function getNotifications()
    {
        if (auth()->check()) {
            $notification = [
                "notifications" => auth()->user()->unreadNotifications()->paginate(7),
                "unread" =>  auth()->user()->unreadNotifications()->count()
            ];
        } else {
            $notification = null;
        }

        return $notification;
    }
}
