<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\System\Application\DTO\AnnounmentData;
use Src\BlendedConcept\System\Application\Mappers\AnnounmentMapper;
use Src\BlendedConcept\System\Domain\Model\Organization;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementEloquentModel;
use Src\BlendedConcept\User\Domain\Model\User;
use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\System\Domain\Resources\AnnouncementResource;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    //get all announcements
    public function getAnnouncements($filters = [])
    {
        $announcements = AnnouncementResource::collection(AnnouncementEloquentModel::filter($filters)->with(['created_by', 'send_to'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        return $announcements;
    }

    // create announcement
    public function createAnnouncement($request)
    {
        $create_by_user = Organization::find($request->created_by);
        $receive_user = User::find($request->send_to);
        $receive_user->notify(new BcNotification(['message' => $request->title, 'from' => $create_by_user->name, 'to' => $receive_user->name, 'type' => $request->type ?? '']));
        $announmentEloquent = AnnounmentMapper::toEloquent($request);
        $announmentEloquent->save();
    }


    //update announcement
    public function updateAnnouncement(AnnounmentData $annountment)
    {
        $announcementArray = $annountment->toArray();
        $announemtEloquent = AnnouncementEloquentModel::query()->find($annountment->id);
        $create_by_user = Organization::find($annountment->created_by);
        $receive_user = User::find($annountment->send_to);
        $receive_user->notify(new BcNotification(['message' => $annountment->title, 'from' => $create_by_user->name, 'to' => $receive_user->name, 'type' => $annountment->type ?? '']));
        $announemtEloquent->fill($announcementArray);
        $announemtEloquent->save();
    }


    public function delete(int $annountment_id) : void
    {
        $annount = AnnouncementEloquentModel::query()->findOrFail($annountment_id);
        $annount->delete();
    }

}
