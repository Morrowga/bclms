<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\System\Application\DTO\AnnounmentData;
use Src\BlendedConcept\System\Application\Mappers\AnnounmentMapper;
use Src\BlendedConcept\System\Domain\Repositories\AnnouncementRepositoryInterface;
use Src\BlendedConcept\System\Domain\Resources\AnnouncementResource;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementEloquentModel;
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
        $create_by_user = OrganizationEloquentModel::find($request->created_by);
        $receive_user = UserEloquentModel::find($request->send_to);
        $receive_user->notify(new BcNotification(['message' => $request->title, 'from' => $create_by_user->name, 'to' => $receive_user->name, 'type' => $request->type ?? '']));
        $announmentEloquent = AnnounmentMapper::toEloquent($request);
        $announmentEloquent->save();
    }

    //update announcement
    public function updateAnnouncement(AnnounmentData $annountment)
    {
        $announcementArray = $annountment->toArray();
        $announemtEloquent = AnnouncementEloquentModel::query()->find($annountment->id);
        $create_by_user = OrganizationEloquentModel::find($annountment->created_by);
        $receive_user = UserEloquentModel::find($annountment->send_to);
        $receive_user->notify(new BcNotification(['message' => $annountment->title, 'from' => $create_by_user->name, 'to' => $receive_user->name, 'type' => $annountment->type ?? '']));
        $announemtEloquent->fill($announcementArray);
        $announemtEloquent->save();
    }

    public function delete(int $annountment_id): void
    {
        $annount = AnnouncementEloquentModel::query()->findOrFail($annountment_id);
        $annount->delete();
    }
}
