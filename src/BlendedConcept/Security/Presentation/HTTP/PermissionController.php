<?php

namespace Src\BlendedConcept\Security\Presentation\HTTP;

use Src\BlendedConcept\Security\Application\UseCases\Queries\Permissions\GetPermissionwithPagination;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\Security\Domain\Requests\StorepermissionRequest;
use Src\BlendedConcept\Security\Domain\Requests\UpdatepermissionRequest;
use Src\BlendedConcept\Security\Application\DTO\PermissionData;
use Src\BlendedConcept\Security\Application\Mappers\PermissionMapper;
use Src\BlendedConcept\Security\Application\UseCases\Commands\Permission\StorePermissionCommand;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;
use Src\BlendedConcept\Security\Application\UseCases\Commands\Permission\UpdatePermissionCommand;
use Inertia\Inertia;

class PermissionController extends Controller
{




    /**
     * Display a listing of the permissions.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        try {
            // Retrieve filters from the request
            $filters = request(['name', 'search', 'perPage']);

            // Call the GetPermissionwithPagination class to handle the filtering and pagination
            $permissions = (new GetPermissionwithPagination($filters))->handle();

            // Render the permissions index page using the Inertia.js view
            return Inertia::render('BlendedConcept/Security/Presentation/Resources/Permissions/Index', [
                "permissions" => $permissions['permissions']
            ]);
        } catch (\Exception $e) {
            return Inertia::render('BlendedConcept/Security/Presentation/Resources/Permissions/Index')->with("sytemErrorMessage", $e->getMessage());
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
        try {
            // Authorize the user to create a permission
            $this->authorize('create', Permission::class);
            // Validate the request data
            $request->validated();
            $newPermission = PermissionMapper::fromRequest($request);
            $createNewPermission = (new StorePermissionCommand($newPermission));
            $createNewPermission->execute();

            // Redirect the user to the index page with a success message
            return redirect()->route('permissions.index')->with("successMessage", "Permission created Successfully!");
        } catch (\Exception $e) {
            return Inertia::render('BlendedConcept/Security/Presentation/Resources/Permissions/Index')->with("sytemErrorMessage", $e->getMessage());
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
        try {
            // Authorize the user to edit the permission
            $this->authorize('edit', Permission::class);

            // Validate the request data
            $request->validated();

            // Call the userInterFace to update the permission

            $updatePermission = PermissionData::fromRequest($request, $permission->id);

            $updatePermission = (new UpdatePermissionCommand($updatePermission));
            $updatePermission->execute();
            // Redirect the user to the index page with a success message
            return redirect()->route('permissions.index')->with("successMessage", "Permission updated Successfully!");
        } catch (\Exception $e) {
            return Inertia::render('BlendedConcept/Security/Presentation/Resources/Permissions/Index')->with("sytemErrorMessage", $e->getMessage());
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
        try {
            $this->authorize('destroy', Permission::class);
            $permission->delete();
            return redirect()->route('permissions.index')->with("successMessage", "Permission deleted successfully!");
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the deletion process
            return redirect()->route('permissions.index')->with("sytemErrorMessage", $e->getMessage());
        }
    }
}
