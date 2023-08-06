<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\System\Presentation\HTTP\DashBoardController;
use Src\BlendedConcept\System\Presentation\HTTP\AnnouncementController;
use Src\BlendedConcept\System\Presentation\HTTP\SettingController;
use Src\BlendedConcept\System\Presentation\HTTP\LibraryController;
use Src\BlendedConcept\System\Presentation\HTTP\NotificationController;

Route::get('/', function () {

    return redirect('/bc/index');
});

Route::get('/admin', function () {

    return redirect('/home');
});
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [DashBoardController::class, 'superAdminDashboard'])->name('dashboard');

    // announcement
    Route::resource("announcements", AnnouncementController::class);

    Route::get('settings', [SettingController::class, 'index'])->name('settings');

    Route::get("libraries", [LibraryController::class, 'index'])->name('libraries');

    Route::post('settings', [SettingController::class, 'UpdateSetting'])->name('updateSetting');



    /***
     * This route handles system-related notifications.
     *
     * It is used when the admin sends actions to users, such as organizations or individuals.
     * The purpose of this route is to retrieve notifications from the system.
     *
     * Notifications can be sent to inform users about various actions or updates within the system.
     * Examples of such actions include changes to an organization's settings, updates on user accounts,
     * or important announcements from the admin.
     * This route provides a way for users to receive these notifications and stay informed about
     * relevant activities happening within the system.
     */
    //mark as read with id
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name("markAsRead");

    //mark as read all
    Route::post('/notifications/readall', [NotificationController::class, 'readAll'])->name("markAsReadAll");

    //get all notifications
    Route::get('/notifications/index', [NotificationController::class, "getAllNotifications"])->name("notifications");


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
