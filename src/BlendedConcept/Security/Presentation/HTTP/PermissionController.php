<?php

namespace Src\BlendedConcept\Security\Presentation\HTTP;

use Src\BlendedConcept\Security\Application\UseCases\Queries\Permissions\GetPermissionwithPagination;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\Security\Application\Requests\StorepermissionRequest;
use Src\BlendedConcept\Security\Application\Requests\UpdatepermissionRequest;
use Src\BlendedConcept\Security\Application\DTO\PermissionData;
use Src\BlendedConcept\Security\Application\Mappers\PermissionMapper;
use Src\BlendedConcept\Security\Application\UseCases\Commands\Permission\StorePermissionCommand;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;
use Src\BlendedConcept\Security\Application\UseCases\Commands\Permission\UpdatePermissionCommand;
use Inertia\Inertia;
use Src\BlendedConcept\Security\Application\Policies\PermissionPolicy;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{

    /**
     * Display a listing of the permissions.
     *
     * @return \Inertia\Response
     */
    public function index()
    {


        //check permission user's has permission
        abort_if(authorize('view', PermissionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // Retrieve filters from the request
            $filters = request(['name', 'search', 'perPage']);

            // Call the GetPermissionwithPagination class to handle the filtering and pagination
            $permissions = (new GetPermissionwithPagination($filters))->handle();

            // Render the permissions index page using the Inertia.js view
            return Inertia::render(config('route.permissions'), [
                "permissions" => $permissions['permissions']
            ]);
        } catch (\Exception $e) {
            return Inertia::render(config('route.permissions'))->with("sytemErrorMessage", $e->getMessage());
        }
    }


    /**
     * Store a newly created permission in storage.
     *
     * @param  StorepermissionRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function store(StorepermissionRequest $request)
    {
        // Authorize the user to create a permission
        abort_if(authorize('create', PermissionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            // Validate the request data
            $request->validated();
            $newPermission = PermissionMapper::fromRequest($request);
            $createNewPermission = (new StorePermissionCommand($newPermission));
            $createNewPermission->execute();

            // Redirect the user to the index page with a success message
            return redirect()->route('permissions.index')->with("successMessage", "Permission created Successfully!");
        } catch (\Exception $e) {
            return Inertia::render(config('route.permissions'))->with("sytemErrorMessage", $e->getMessage());
        }
    }



    /**
     * Update the specified permission in storage.
     *
     * @param   UpdatepermissionRequest  $request
     * @param  PermissionEloquentModel  $permission
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function update(UpdatepermissionRequest $request, PermissionEloquentModel $permission)
    {
        // Authorize the user to edit the permission

        abort_if(authorize('edit', PermissionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            // Validate the request data
            $request->validated();

            // Call the userInterFace to update the permission

            $updatePermission = PermissionData::fromRequest($request, $permission->id);

            $updatePermission = (new UpdatePermissionCommand($updatePermission));
            $updatePermission->execute();
            // Redirect the user to the index page with a success message
            return redirect()->route('permissions.index')->with("successMessage", "Permission updated Successfully!");
        } catch (\Exception $e) {
            return Inertia::render(config('route.permissions'))->with("sytemErrorMessage", $e->getMessage());
        }
    }

    /**
     *  Delete a permission.
     * @param PermissionEloquentModel $permission The permission to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the permissions index page.
     *
     */
    public function destroy(PermissionEloquentModel $permission)
    {

        abort_if(authorize('destroy', PermissionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $permission->delete();
            return redirect()->route('permissions.index')->with("successMessage", "Permission deleted successfully!");
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the deletion process
            return redirect()->route('permissions.index')->with("sytemErrorMessage", $e->getMessage());
        }
    }
}
