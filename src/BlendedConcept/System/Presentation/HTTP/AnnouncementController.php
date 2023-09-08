<?php

namespace Src\BlendedConcept\System\Presentation\HTTP;

use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\System\Application\DTO\AnnounmentData;
use Src\BlendedConcept\System\Domain\Services\AnnounmnetService;
use Src\BlendedConcept\System\Application\Mappers\AnnounmentMapper;
use Src\BlendedConcept\System\Application\Policies\AnnouncementPolicy;
use Src\BlendedConcept\System\Application\Requests\StoreAnnouncementRequest;
use Src\BlendedConcept\System\Application\UseCases\Queries\ShowAnnouncement;
use Src\BlendedConcept\System\Application\Requests\UpdateAnnouncementRequest;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Users\GetUserList;
use Src\BlendedConcept\System\Application\UseCases\Queries\GetOrganizationList;
use Src\BlendedConcept\System\Application\UseCases\Commands\StoreAnnounmentCommand;
use Src\BlendedConcept\System\Application\UseCases\Commands\DeleteAnnounmentCommand;
use Src\BlendedConcept\System\Application\UseCases\Commands\UpdateAnnounmentCommand;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementEloquentModel;
use Src\BlendedConcept\System\Application\UseCases\Queries\GetAnnounmetAllWithPagination;

class AnnouncementController extends Controller
{

    //get all announcements
    public function index()
    {
        // Authorize user
        abort_if(authorize('view', AnnouncementPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // Get filters from request
            $filters = request()->only(['name', 'search', 'perPage']);

            // Get user list
            $users = (new GetUserList())->handle();

            // Get organization list
            $organizations = (new GetOrganizationList())->handle();

            // Get announcements with pagination
            $announcements = (new GetAnnounmetAllWithPagination($filters))->handle();

            // Render Inertia view
            return Inertia::render(config('route.announment.index'), [
                'announcements' => $announcements,
                'users' => $users,
                'organizations' => $organizations,
            ]);
        } catch (\Exception $e) {
            return Inertia::render(config('route.announment.index'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function create()
    {

        $organizations = (new GetOrganizationList())->handle();

        return Inertia::render(config('route.announment.create'), [
            'organizations' => $organizations,
        ]);
    }

    /**
     * This function stores a new announcement.
     *
     * @param  StoreAnnouncementRequest  $request The request object
     * @return \Illuminate\Http\RedirectResponse The redirect response
     */
    public function store(StoreAnnouncementRequest $request)
    {

        abort_if(authorize('create', AnnouncementPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            $request->validated();
            //Creates a new announcement object from the request data.
            $newAnnoument = AnnounmentMapper::fromRequest($request);
            // Creates a new StoreAnnounmentCommand object and executes it.
            $storeAnnounmentCommand = new StoreAnnounmentCommand($newAnnoument);
            $storeAnnounmentCommand->execute();
        } catch (\Exception $e) {

            // Handle the exception here
            dd($e->getMessage());

            return redirect()->route('announcements.index')->with('systemErrorMessage', $e->getMessage());
        }

        /**
         * Returns a redirect response to the announcements index page.
         */
        return redirect()->route('announcements.index')->with('successMessage', 'Announcement created Successfully!');
    }

    public function edit($id)
    {

        $announcement = (new ShowAnnouncement($id))->handle();

        $organizations = (new GetOrganizationList())->handle();

        return Inertia::render(config('route.announment.edit'), [
            'organizations' => $organizations,
            'announcement' => $announcement
        ]);
    }

    /**
     * Update an announcement.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAnnouncementRequest $request, AnnouncementEloquentModel $announcement)
    {

        abort_if(authorize('edit', AnnouncementPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

            return redirect()->route('announcements.index')->with('successMessage', 'Announcement updated Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('announcements.index')->with('SystemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Delete an announcement.
     *
     * @param  AnnouncementEloquentModel  $announcement The announcement to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AnnouncementEloquentModel $announcement)
    {

        abort_if(authorize('destroy', AnnouncementPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /**
         * Try to delete the announcement.
         */
        try {

            $announment = new DeleteAnnounmentCommand($announcement->id);
            $announment->execute();

            return redirect()->route('announcements.index')->with('successMessage', 'Announcement deleted Successfully!');
        } catch (\Exception $e) {
            /**
             * Catch any exceptions and display an error message.
             */
            return redirect()->route('announcements.index')->with('systemErrorMessage', $e->getMessage());
        }
    }
}
