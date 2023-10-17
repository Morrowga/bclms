<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\System\Domain\Repositories\NotificationRepositoryInterface;

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
                'notifications' => auth()->user()->unreadNotifications()
                ->whereJsonDoesntContain('data->type', 'HomeAnnounce')
                ->paginate(7),
                'unread' => auth()->user()->unreadNotifications()->count(),
            ];
        } else {
            $notification = null;
        }

        return $notification;
    }
}
