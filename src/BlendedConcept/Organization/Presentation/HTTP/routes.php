<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Organization\Presentation\HTTP\DashBoardController;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationController;
use Src\BlendedConcept\Organization\Presentation\HTTP\PlanController;


Route::get('/', function () {

    return redirect('/bc/index');

});
Route::get('/admin', function () {

    return redirect('/home');

});
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [DashBoardController::class, 'superAdminDashboard'])->name('dashboard');
    Route::resource('organizations', OrganizationController::class);
    Route::resource('plans', PlanController::class);

});



Route::group(['middleware' => ['auth', 'isSuperAdmin']], function () {

    // handle pagebuilder asset requests
    Route::any(config('pagebuilder.general.assets_url') . '{any}', [DashBoardController::class, 'getAssertUrl'])
    ->where('any', '.*');

    // handle all website manager requests
    if (config('pagebuilder.website_manager.use_website_manager')) {

        Route::any(config('pagebuilder.website_manager.url') . '{any}', [DashBoardController::class, 'websiteManagerUrl'])->where('any', '.*');
    }

    // pass all remaining requests to the LaravelPageBuilder router
    if (config('pagebuilder.router.use_router')) {

        Route::any('/bc/{any}', [DashBoardController::class, 'UseRouter'])
        ->where('any', '.*')
        ->withoutMiddleware(['auth', 'isSuperAdmin']);
    }
});

// handle requests to retrieve uploaded file
Route::any(config('pagebuilder.general.uploads_url') . '{any}', [DashBoardController::class, 'uploadsUrl'])
->where('any', '.*');
