<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\System\Application\DTO\AnnounmentData;
use Src\BlendedConcept\System\Application\Mappers\AnnounmentMapper;
use Src\BlendedConcept\System\Application\UseCases\Commands\DeleteAnnounmentCommand;
use Src\BlendedConcept\System\Application\UseCases\Commands\StoreAnnounmentCommand;
use Src\BlendedConcept\System\Application\UseCases\Commands\UpdateAnnounmentCommand;
use Src\BlendedConcept\System\Application\UseCases\Queries\GetAnnounmetAllWithPagination;
use Src\BlendedConcept\System\Application\UseCases\Queries\GetOrganizationList;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementEloquentModel;
use Src\BlendedConcept\User\Application\UseCases\Queries\GetUserList;
use Src\BlendedConcept\System\Domain\Requests\StoreAnnouncementRequest;
use Src\BlendedConcept\System\Domain\Requests\UpdateAnnouncementRequest;
use Src\Common\Infrastructure\Laravel\Controller;


class AnnouncementController extends Controller
{


    //get all announcements
    public function index()
    {
        try {
            // Authorize user
            $this->authorize('view', AnnouncementEloquentModel::class);

            // Get filters from request
            $filters = request()->only(['name', 'search', 'perPage']);

            // Get user list
            $users = (new GetUserList())->handle();

            // Get organization list
            $organizations = (new GetOrganizationList())->handle();

            // Get announcements with pagination
            $announcements = (new GetAnnounmetAllWithPagination($filters))->handle();

            // Render Inertia view
            return Inertia::render('BlendedConcept/System/Presentation/Resources/Announcements/Index', [
                "announcements" => $announcements,
                "users" => $users,
                "organizations" => $organizations
            ]);
        } catch (\Exception $e) {
            return Inertia::render('BlendedConcept/System/Presentation/Resources/Announcements/Index')->with("sytemErrorMessage", $e->getMessage());
        }
    }



    /**
     * This function stores a new announcement.
     *
     * @param StoreAnnouncementRequest $request The request object
     * @return \Illuminate\Http\RedirectResponse The redirect response
     */
    public function store(StoreAnnouncementRequest $request)
    {


        try {
            $this->authorize('create', Announcement::class);
            $request->validated();
            //Creates a new announcement object from the request data.
            $newAnnoument = AnnounmentMapper::fromRequest($request);
            // Creates a new StoreAnnounmentCommand object and executes it.
            $storeAnnounmentCommand = new StoreAnnounmentCommand($newAnnoument);
            $storeAnnounmentCommand->execute();
        } catch (\Exception $e) {

            // Handle the exception here
            return redirect()->route('announcements.index')->with("systemErrorMessage", $e->getMessage());
        }


        /**
         * Returns a redirect response to the announcements index page.
         */
        return redirect()->route('announcements.index')->with("successMessage", "Announcement created Successfully!");
    }



    /**
     * Update an announcement.
     *
     * @param UpdateAnnouncementRequest $request
     * @param AnnouncementEloquentModel $announcement
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAnnouncementRequest $request, AnnouncementEloquentModel $announcement)
    {
        /**
         * @throws \Illuminate\Auth\Access\AuthorizationException
         */
        $this->authorize('edit', Announcement::class);

        /**
         * Validate the request.
         */
        $request->validated();

        /**
         * Try to update the announcement.
         */
        try {
            $announcement = AnnounmentData::fromRequest($request, $announcement->id);
            $updateAnnounmentCommand = (new UpdateAnnounmentCommand($announcement));
            $updateAnnounmentCommand->execute();
            return redirect()->route('announcements.index')->with("successMessage", "Announcement updated Successfully!");
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('announcements.index')->with("SystemErrorMessage", $e->getMessage());
        }
    }

    /**
     * Delete an announcement.
     *
     * @param AnnouncementEloquentModel $announcement The announcement to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AnnouncementEloquentModel $announcement)
    {
        /**
         * @throws \Illuminate\Auth\Access\AuthorizationException
         */
        $this->authorize('destroy', Announcement::class);

        /**
         * Try to delete the announcement.
         */
        try {
            (new DeleteAnnounmentCommand($announcement->id))->execute();

            return redirect()->route('announcements.index')->with("successMessage", "Announcement deleted Successfully!");
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('announcements.index')->with("systemErrorMessage", $e->getMessage());
        }
    }
}
