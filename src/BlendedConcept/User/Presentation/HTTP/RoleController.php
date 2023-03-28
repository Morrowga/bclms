<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;

use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\User\Domain\Requests\StoreRoleRequest;
use Src\BlendedConcept\User\Domain\Requests\UpdateRoleRequest;
use Src\BlendedConcept\User\Domain\Model\Role;

use Inertia\Inertia;

class RoleController extends Controller
{

  private $userInterFace;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userInterFace = $userRepository;
  }


  public function index()
  {
    $this->authorize('view', Role::class);
    $roles = $this->userInterFace->getRole()->load('permissions');
    return Inertia::render('BlendedConcept::User/Presentation/Resources/Roles/Index', compact('roles'));
  }

  public function create()
  {
    $this->authorize('create', Role::class);
    $permissions = $this->userInterFace->getPermission();
    return Inertia::render('BlendedConcept::User/Presentation/Resources/Roles/Create', compact('permissions'));
  }

  public function store(StoreRoleRequest $request)
  {
    $this->authorize('store', Role::class);
    $request->validated();
    $this->userInterFace->createRole($request);
    return redirect()->route('roles.index')->with("successMessage", "Roles created Successfully!");
  }

  public function edit(Role $role)
  {
    $this->authorize('edit', Role::class);
    $role =  $role->load('permissions');
    $permissions = $this->userInterFace->getPermission();
    return Inertia::render('BlendedConcept::User/Presentation/Resources/Roles/Edit', compact('role', 'permissions'));
  }

  public function update(UpdateRoleRequest $request, Role $role)
  {
    $this->authorize('update', Role::class);
    $this->userInterFace->updateRole($request, $role);
    return redirect()->route('roles.index')->with("successMessage", "Role updated Successfully!");
  }

  public function show(Role $role)
  {
  }

  public function destroy(Role $role)
  {
    $this->authorize('destroy', Role::class);
    $role->delete();
    return redirect()->route('roles.index')->with("successMessage", "Role deleted Successfully!");
  }
}
