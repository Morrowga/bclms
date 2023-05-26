<?php

namespace Src\BlendedConcept\Security\Application\Repositories\Eloquent;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\BlendedConcept\User\Domain\Repositories\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    //mark as read with id
    public function read($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();
    }

    //mark as read all
    public function readAll()
    {
        $notification = auth()->user()->unreadNotifications()->get();
        $notification->markAsRead();
    }

    //get notifications by user
    public function notifications()
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
