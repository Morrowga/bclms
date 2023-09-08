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
        $announcements = AnnouncementResource::collection(AnnouncementEloquentModel::filter($filters)->with(['author_id', 'target_role_id'])->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $announcements;
    }

    // create announcement
    public function createAnnouncement($request)
    {
        $create_by_user = OrganizationEloquentModel::find($request->author_id);
        $receive_user = UserEloquentModel::find($request->target_role_id);
        $receive_user->notify(new BcNotification(['message' => $request->title, 'from' => $create_by_user->name, 'to' => $receive_user->name, 'type' => $request->type ?? '']));
        $announmentEloquent = AnnounmentMapper::toEloquent($request);
        $announmentEloquent->save();
    }

    public function showAnnouncement($id)
    {
        $announcement = new AnnouncementResource(AnnouncementEloquentModel::where('id', $id)->with(['author_id', 'target_role_id'])->first());

        return $announcement;
    }

    //update announcement
    public function updateAnnouncement(AnnounmentData $annountment)
    {
        $announcementArray = $annountment->toArray();
        $announemtEloquent = AnnouncementEloquentModel::query()->find($annountment->id);
        $create_by_user = OrganizationEloquentModel::find($annountment->author_id);
        $receive_user = UserEloquentModel::find($annountment->target_role_id);
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
