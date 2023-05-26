<?php

namespace Src\BlendedConcept\Security\Presentation\HTTP;

use Src\Common\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Src\BlendedConcept\Security\Application\DTO\UserData;
use Src\BlendedConcept\Security\Application\Mappers\UserMapper;
use Src\BlendedConcept\Security\Application\UseCases\Commands\User\StoreUserCommand;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Users\GetUserName;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Roles\getRoleName;
use Src\BlendedConcept\Security\Domain\Model\User;
use Src\BlendedConcept\Security\Domain\Requests\StoreUserRequest;
use Src\BlendedConcept\Security\Domain\Requests\UpdateUserRequest;
use Src\BlendedConcept\Security\Domain\Requests\updateUserPasswordRequest;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Security\Application\UseCases\Queries\Users\GetUsersWithPagination;
use Src\BlendedConcept\Security\Application\UseCases\Commands\User\UpdateUserCommand;

class UserController extends Controller
{



    /***
     *  @params null
     *
     *  @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     *
     */
    public function index()
    {

        try {
            // Check if the user is authorized to view users
            $this->authorize('view', UserEloquentModel::class);

            // Get the filters from the request, or initialize an empty array if they are not present
            $filters = request()->only(['name', 'email', 'role', 'search', 'perPage', 'roles']) ?? [];

            // Retrieve users with pagination using the provided filters
            $users = (new GetUsersWithPagination($filters))->handle();

            // Retrieve user names
            $users_name = (new GetUserName())->handle();

            // Retrieve role names
            $roles_name = (new getRoleName())->handle();
            // Render the Inertia view with the obtained data
            return Inertia::render('BlendedConcept/Security/Presentation/Resources/Users/Index', [
                'users' => $users,
                'users_name' => $users_name,
                'roles_name' => $roles_name
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('users.index')->with('sytemErrorMessage', $e->getMessage());
        }
    }
    /**
     * Store a new user.
     *
     * @param StoreUserRequest $request The incoming request.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $this->authorize('create', User::class);

            $request->validated();
            $newUser = UserMapper::fromRequest($request);

            $createNewUser = new StoreUserCommand($newUser);
            $createNewUser->execute();

            return redirect()->route('users.index')->with("successMessage", "User created successfully!");
        } catch (\Exception $e) {
            // Handle the exception, log the error, or display a user-friendly error message.
            return redirect()->route('users.index')->with("sytemErrorMessage",$e->getMessage());

        }
    }



    //update user
    public function update(UpdateUserRequest $request, UserEloquentModel $user)
    {
        $this->authorize('edit', User::class);

        $updateUser = UserData::fromRequest($request,$user->id);
        $updatedUserCommand = (new UpdateUserCommand($updateUser));

        $updatedUserCommand->execute();
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
