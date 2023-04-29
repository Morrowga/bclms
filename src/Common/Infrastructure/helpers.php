<?php
use Illuminate\Support\Facades\Cache;

//Notification Helper to Vue Component
if (!function_exists('getNotifications')) {
    function getNotifications()
    {
        $notification = Cache::remember('unread_notifications_' . auth()->id(), 60, function () {
            return auth()->user()
                ? auth()->user()->unreadNotifications()->with('notifiable')->paginate(7)
                : null;
        });

        $notification = $notification
            ? ["notifications" => $notification,"unread" =>  $notification->total()]
            : null;

        return $notification;
    }
}
