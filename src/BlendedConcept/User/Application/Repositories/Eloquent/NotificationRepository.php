<?php

namespace Src\BlendedConcept\User\Application\Repositories\Eloquent;

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
}
