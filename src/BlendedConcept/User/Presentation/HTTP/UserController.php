<?php

namespace Src\BlendedConcept\User\Presentation\HTTP;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Src\Common\Infrastructure\Laravel\Controller;
use Src\BlendedConcept\User\Domain\Model\User;
use Src\BlendedConcept\User\Domain\Repositories\UserRepositoryInterface;
use Src\BlendedConcept\User\Domain\Requests\StoreUserRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Src\BlendedConcept\User\Domain\Requests\UpdateUserRequest;
use Src\BlendedConcept\User\Domain\Requests\updateUserPasswordRequest;

class UserController extends Controller
{

  private $userInterFace;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userInterFace = $userRepository;
  }

  //get all users
  public function index(Request $request)
  {
    $this->authorize('view', User::class);
    $filters = request()->only(['name', 'email', 'role', 'search', 'perPage', 'roles']);
    $users = $this->userInterFace->getUsers($filters);
    $users_name = $this->userInterFace->getUsersName();
    $roles_name = $this->userInterFace->getRolesName();
    return Inertia::render('BlendedConcept/User/Presentation/Resources/Users/Index', [
      'users' => $users,
      'users_name' => $users_name,
      'roles_name' => $roles_name
    ]);
  }

  //store user
  public function store(StoreUserRequest $request)
  {
    $this->authorize('create', User::class);
    $request->validated();
    $this->userInterFace->createUser($request);
    return redirect()->route('users.index')->with("successMessage", "User Create Successfully!");
  }

  //update user
  public function update(UpdateUserRequest $request, User $user)
  {
    $this->authorize('edit', User::class);
    $this->userInterFace->updateUser($request, $user);



    return redirect()->route('users.index')->with("successMessage", "User Updated Successfully!");
  }

  public function destroy(User $user)
  {
    $this->authorize('destroy', User::class);
    $user->delete();
    return redirect()->route('users.index')->with("successMessage", "User Deleted Successfully!");
  }

  public function changePassword(updateUserPasswordRequest $request)
  {
    $this->userInterFace->changepassword($request);
    return redirect()->route('userprofile')->with("successMessage", "Password Updated Successfully!");
  }
}
