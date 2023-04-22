<?php

use HansSchouten\LaravelPageBuilder\LaravelPageBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Src\Auth\Presentation\HTTP\AuthController;

Route::group(['middleware' => ['guest']], function () {
    Route::get("login", [AuthController::class, 'loginPage'])->name('login');
    Route::post("login", [AuthController::class, 'login'])->name('login-post');
    Route::get("verify", [AuthController::class, 'verify'])->name('verify');
    Route::get("register", [AuthController::class, 'register'])->name('register');
    Route::post("b2cstore", [AuthController::class, 'B2CStore'])->name('b2cstore');
    Route::get("verification", [AuthController::class, 'verification'])->name("verification");
});
Route::group(['middleware' => ['auth']], function () {
    // logout function
    Route::post("logout", [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth', 'isSuperAdmin']], function () {
    // handle pagebuilder asset requests
    Route::any(config('pagebuilder.general.assets_url') . '{any}', function () {

        $builder = new LaravelPageBuilder(config('pagebuilder'));
        $builder->handlePageBuilderAssetRequest();
    })->where('any', '.*');

    if (config('pagebuilder.website_manager.use_website_manager')) {

        // handle all website manager requests
        Route::any(config('pagebuilder.website_manager.url') . '{any}', function () {

            $builder = new LaravelPageBuilder(config('pagebuilder'));
            $builder->handleAuthenticatedRequest();
        })->where('any', '.*');
    }


    if (config('pagebuilder.router.use_router')) {
        // pass all remaining requests to the LaravelPageBuilder router
        Route::any('/bc/{any}', function () {
            $builder = new LaravelPageBuilder(config('pagebuilder'));
            $hasPageReturned = $builder->handlePublicRequest();

            if (request()->path() === '/bc' && !$hasPageReturned) {
                $builder->getWebsiteManager()->renderWelcomePage();
            }
        })->where('any', '.*')->withoutMiddleware(['auth', 'isSuperAdmin']);
    }
});

// handle requests to retrieve uploaded file
Route::any(config('pagebuilder.general.uploads_url') . '{any}', function () {

    $builder = new LaravelPageBuilder(config('pagebuilder'));
    $builder->handleUploadedFileRequest();
})->where('any', '.*');
