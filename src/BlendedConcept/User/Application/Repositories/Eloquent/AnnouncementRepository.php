<?php

namespace Src\BlendedConcept\User\Application\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\BlendedConcept\User\Domain\Model\Announcement;
use Src\BlendedConcept\User\Domain\Model\User;
use Src\BlendedConcept\User\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\User\Domain\Resources\AnnouncementResource;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    //get all announcements
    public function getAnnouncements($filters = [])
    {
        $announcements = AnnouncementResource::collection(Announcement::filter($filters)->with(['created_by', 'send_to'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        return $announcements;
    }

    // create announcement
    public function createAnnouncement($request)
    {
        // dd($request->all());
        $create_by_user = User::find($request->created_by);
        $receive_user = User::find($request->send_to);
        $receive_user->notify(new BcNotification(['message' => $request->title, 'from' => $create_by_user->name, 'to' => $receive_user->name, 'type' => "success"]));
        Announcement::create($request->all());
    }

    //update announcement
    public function updateAnnouncement($request, $announcement)
    {
        $create_by_user = User::find($request->created_by);
        $receive_user = User::find($request->send_to);
        $receive_user->notify(new BcNotification(['message' => $request->title, 'from' => $create_by_user->name, 'to' => $receive_user->name, 'type' => "success"]));
        $announcement->update($request->only(['title', 'message']));
    }
}
