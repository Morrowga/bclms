<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Src\Auth\Application\Requests\StoreLoginRequest;
use Src\Auth\Presentation\HTTP\AuthController;
use Src\BlendedConcept\ClassRoom\Presentation\HTTP\ClassRoomController;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Presentation\HTTP\StudentController;
use Src\BlendedConcept\System\Presentation\HTTP\DashBoardController;
use Src\BlendedConcept\System\Presentation\HTTP\LibraryController;
use Src\BlendedConcept\Teacher\Presentation\HTTP\TeacherController;
use Src\Common\Infrastructure\Laravel\Notifications\BcNotification;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('login', function (StoreLoginRequest $request) {
        $user = UserEloquentModel::query()->where('email', $request->email)->first();

        if ($user) {
            //this check verify email or not
            if (! $user->email_verified_at) {
                $error = 'Please Verify your email';
            }
            /*****
             *  check the current user
             *  is include in this organization
             *
             */

            elseif ($user->organization_id !== tenant()->organization_id) {
                $error = 'Invalid Login Credential';
            } elseif (
                $user->email_verified_at &&
                auth()->attempt([
                    'email' => request('email'),
                    'password' => request('password'),
                ])
            ) {

                $user->notify(new BcNotification(['message' => 'Welcome '.$user->name.' !', 'from' => '', 'to' => '', 'type' => 'success']));

                return redirect()->route('c.organizationaadmin');
            } else {
                $error = 'Invalid Login Credential';
            }
        }

        // if not fail log in
        else {

            $error = 'Invalid Login Credential';
        }

        return Inertia::render(config('route.login'), [
            'errorMessage' => $error,
        ]);
    })->name('login-post');

    // Route::resource('organizations', OrganizationController::class);

    Route::get('/', [DashBoardController::class, 'superAdminDashboard'])->name('organizationaadmin')->middleware('auth');

    Route::resource('teachers', TeacherController::class)->middleware('auth');
    Route::resource('students', StudentController::class)->middleware('auth');

    Route::resource('classrooms', ClassRoomController::class)->middleware('auth');

    // library for teacher roles

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('libraries', [LibraryController::class, 'index'])->middleware('auth');
});
