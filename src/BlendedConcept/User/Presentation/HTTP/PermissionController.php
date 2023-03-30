<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;

use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\BlendedConcept\User\Domain\Requests\StorepermissionRequest;
use Src\BlendedConcept\User\Domain\Requests\UpdatepermissionRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Src\BlendedConcept\User\Domain\Model\Permission;

class PermissionController extends Controller
{


    // initalized interface

    private $userInterFace;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userInterFace = $userRepository;
    }

    public function index()
    {
        $this->authorize('view', Permission::class);
        $filters = request()->only(['name', 'search', 'perPage']);
        $permissions = $this->userInterFace->getPermission($filters);
        return Inertia::render('BlendedConcept::User/Presentation/Resources/Permissions/Index', [
            "permissions" => $permissions['permissions']
        ]);
    }

    public function create()
    {
        $this->authorize('create', Permission::class);
        return Inertia::render('BlendedConcept::User/Presentation/Resources/Permissions/Create');
    }

    public function store(StorepermissionRequest $request)
    {
        $this->authorize('create', Permission::class);
        $request->validated();
        $this->userInterFace->createPermission($request);
        return redirect()->route('permissions.index')->with("successMessage", "Permission created Successfully!");
    }

    public function edit(Permission $permission)
    {
        $this->authorize('edit', Permission::class);
        //edit permisiion
        return Inertia::render('BlendedConcept::User/Presentation/Resources/Permissions/Edit', [
            "permission" => $permission
        ]);
    }

    public function update(UpdatepermissionRequest $request, Permission $permission)
    {
        $this->authorize('edit', Permission::class);
        $request->validated();
        $this->userInterFace->updatePermission($request, $permission);

        return redirect()->route('permissions.index')->with("successMessage", "Permission updated Successfully!");
    }

    public function show($id)
    {
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('destroy', Permission::class);
        //   delete permission
        $permission->delete();

        return  redirect()->route('permissions.index')->with("successMessage", "Permission deleted Successfully!");
    }
}
