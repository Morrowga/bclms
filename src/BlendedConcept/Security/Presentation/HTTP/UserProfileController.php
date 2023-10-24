<?php

namespace Src\BlendedConcept\Security\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\Security\Application\DTO\UserProfileData;
use Src\BlendedConcept\Security\Application\Requests\UpdateUserProfilePasswordRequest;
use Src\BlendedConcept\Security\Application\Requests\UpdateUserProfileRequest;
use Src\BlendedConcept\Security\Application\UseCases\Commands\UserProfile\UpdateUserProfileCommand;
use Src\BlendedConcept\Security\Domain\Services\UserService;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\Common\Infrastructure\Laravel\Controller;

class UserProfileController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = app()->make(UserService::class);
    }

    public function index()
    {
        try {
            return Inertia::render(config('route.userprofile'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, such as displaying a generic error page
            return Inertia::render(route('route.userprofile'))->with('sytemErrorMessage', $e->getMessage());
        }
    }

    public function updateProfile(UpdateUserProfileRequest $request)
    {
        try {
            $user = UserEloquentModel::query()->findOrFail(auth()->user()->id);
            $updateUser = UserProfileData::fromRequest($request, $user->id);
            $updatedUserCommand = (new UpdateUserProfileCommand($updateUser));
            $updatedUserCommand->execute();

            return redirect()->route('userprofile')->with('successMessage', 'Your Profile Was Updated Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());

        }
    }

    public function changePassword(UpdateUserProfilePasswordRequest $request)
    {
        try {
            $isPasswordMatch = $this->userService->changePassword($request);
            if ($isPasswordMatch) {
                return redirect()->route('userprofile')->with('successMessage', 'Password Updated Successfully!');
            }

            return redirect()->route('userprofile')->with('errorMessage', 'Password does not match!');
        } catch (\Throwable $th) {
            return redirect()->route('userprofile')->with('errorMessage', 'Password does not match!');
        }
    }
}
