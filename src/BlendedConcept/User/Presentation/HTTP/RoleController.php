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

  // get all roles
  public function index()
  {
    $this->authorize('view', Role::class);
    $filters = request()->only(['name', 'search', 'perPage']);
    $roles = $this->userInterFace->getRole($filters);
    $roles_name = $this->userInterFace->getRolesName();
    $permissions =  $this->userInterFace->getPermission();
    return Inertia::render('BlendedConcept/User/Presentation/Resources/Roles/Index', [
      "roles" => $roles['paginate_roles'],
      "roles_name" => $roles_name,
      "permissions" => $permissions["default_permissions"]
    ]);
  }

  //store role
  public function store(StoreRoleRequest $request)
  {
    // dd($this);
    $this->authorize('create', Role::class);
    $request->validated();
    $this->userInterFace->createRole($request);
    return redirect()->route('roles.index')->with("successMessage", "Roles created Successfully!");
  }

  //update role
  public function update(UpdateRoleRequest $request, Role $role)
  {
    $this->authorize('edit', Role::class);
    $this->userInterFace->updateRole($request, $role);
    return redirect()->route('roles.index')->with("successMessage", "Role updated Successfully!");
  }

  //destroy role
  public function destroy(Role $role)
  {
    $this->authorize('destroy', Role::class);
    $role->delete();
    return redirect()->route('roles.index')->with("successMessage", "Role deleted Successfully!");
  }
}
