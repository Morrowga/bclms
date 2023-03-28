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
        $permissions = $this->userInterFace->getPermission();
        return Inertia::render('BlendedConcept::User/Presentation/Resources/Permissions/Index', compact('permissions'));
    }

    public function create()
    {
        $this->authorize('create', Permission::class);
        return Inertia::render('BlendedConcept::User/Presentation/Resources/Permissions/Create');
    }

    public function store(StorepermissionRequest $request)
    {
        $this->authorize('store', Permission::class);
        $request->validated();
        $this->userInterFace->createPermission($request);
        return redirect()->route('permissions.index')->with("successMessage", "Permission created Successfully!");
    }

    public function edit(Permission $permission)
    {
        $this->authorize('edit', Permission::class);
        //edit permisiion
        return Inertia::render('BlendedConcept::User/Presentation/Resources/Permissions/Edit', compact('permission'));
    }

    public function update(UpdatepermissionRequest $request, Permission $permission)
    {
        $this->authorize('update', Permission::class);
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
