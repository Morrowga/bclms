<?php

namespace Src\BlendedConcept\Security\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Security\Application\Policies\PermissionPolicy;
use Src\BlendedConcept\Security\Application\Requests\StorepermissionRequest;
use Src\BlendedConcept\Security\Application\Requests\UpdatepermissionRequest;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Permissions\GetPermissionwithPagination;
use Src\BlendedConcept\Security\Domain\Services\PermissionService;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;
use Src\Common\Infrastructure\Laravel\Controller;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    protected $permissionServices;

    public function __construct()
    {
        $this->permissionServices = app()->make(PermissionService::class);
    }

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
                'permissions' => $permissions['permissions'],
            ]);
        } catch (\Exception $e) {
            return Inertia::render(config('route.permissions'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Store a newly created permission in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function store(StorepermissionRequest $request)
    {
        // Authorize the user to create a permission
        abort_if(authorize('create', PermissionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {

            //this is service is used to createPermission Services
            $this->permissionServices->createPermission($request);
            // Redirect the user to the index page with a success message
            return redirect()->route('permissions.index')->with('successMessage', 'Permission created Successfully!');

        } catch (\Exception $e) {
            return Inertia::render(config('route.permissions'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    /**
     * Update the specified permission in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function update(UpdatepermissionRequest $request, PermissionEloquentModel $permission)
    {
        // Authorize the user to edit the permission

        abort_if(authorize('edit', PermissionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            // this service to use to handle service
            $this->permissionServices->updatePermission($request, $permission->id);

            // Redirect the user to the index page with a success message
            return redirect()->route('permissions.index')->with('successMessage', 'Permission updated Successfully!');
        } catch (\Exception $e) {
            return Inertia::render(config('route.permissions'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    /**
     *  Delete a permission.
     *
     * @param  PermissionEloquentModel  $permission The permission to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the permissions index page.
     */
    public function destroy(PermissionEloquentModel $permission)
    {

        abort_if(authorize('destroy', PermissionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            //delete permission
            $this->permissionServices->deletePermission($permission);

            return redirect()->route('permissions.index')->with('successMessage', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the deletion process
            return redirect()->route('permissions.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
}
