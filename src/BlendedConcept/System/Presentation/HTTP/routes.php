<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\System\Presentation\HTTP\UIController;
use Src\BlendedConcept\System\Presentation\HTTP\ReportController;
use Src\BlendedConcept\System\Presentation\HTTP\LibraryController;
use Src\BlendedConcept\System\Presentation\HTTP\SettingController;
use Src\BlendedConcept\System\Presentation\HTTP\DashBoardController;
use Src\BlendedConcept\System\Presentation\HTTP\AnnouncementController;
use Src\BlendedConcept\System\Presentation\HTTP\NotificationController;
use Src\BlendedConcept\System\Presentation\HTTP\TechnicalSupportController;

Route::get('/', function () {
    return redirect('/bc/index');
});

Route::get('/admin', function () {

    return redirect('/home');
});

Route::post('/bc/sendemail-contact', [UIController::class, 'sendMail']);

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [DashBoardController::class, 'superAdminDashboard'])->name('dashboard');
    Route::get('/profiling-survey-b2c', [DashBoardController::class, 'profilingSurvey'])->name('profilingSurvey');
    Route::get('/learning-portal', [DashBoardController::class, 'learningPortal'])->name('learning-portal');
    // announcement
    Route::resource('announcements', AnnouncementController::class);

    Route::get('announcements/b2bteacher-by-org/{id}', [AnnouncementController::class, 'getB2bTeachers'])->name('announcements.getb2bteachersbyorg');

    Route::get('settings', [SettingController::class, 'index'])->name('settings');

    Route::get('libraries', [LibraryController::class, 'index'])->name('libraries');

    Route::post('settings', [SettingController::class, 'UpdateSetting'])->name('updateSetting');

    Route::get('updateSiteTheme', [SettingController::class, 'updateSiteTheme'])->name('updateSiteTheme');

    Route::put('updatetheme/{system_themes}', [SettingController::class, 'updatetheme'])->name('updatetheme');

    Route::get('supports', [TechnicalSupportController::class, 'index'])->name('supports');

    Route::get('techsupports', [TechnicalSupportController::class, 'techsupports'])->name('techsupports');

    Route::post('techsupports', [TechnicalSupportController::class, 'askSupportQuestion'])->name('techsupport');

    Route::put('techsupports/{support_ticket}', [TechnicalSupportController::class, 'answerSupportQuestion'])->name('answerSupportQuestion');

    Route::delete('techsupports/{support_ticket}', [TechnicalSupportController::class, 'deleteSupportQuestion'])->name('deleteSupportQuestion');

    /***
     * This route handles system-related notifications.
     *
     * It is used when the admin sends actions to users, such as organisations or individuals.
     * The purpose of this route is to retrieve notifications from the system.
     *
     * Notifications can be sent to inform users about various actions or updates within the system.
     * Examples of such actions include changes to an organisation's settings, updates on user accounts,
     * or important announcements from the admin.
     * This route provides a way for users to receive these notifications and stay informed about
     * relevant activities happening within the system.
     */
    //mark as read with id
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('markAsRead');

    //mark as read all
    Route::post('/notifications/readall', [NotificationController::class, 'readAll'])->name('markAsReadAll');

    //get all notifications
    Route::get('/notifications/index', [NotificationController::class, 'getAllNotifications'])->name('notifications');

    //org teacher profile
    Route::get('/profiles/org-teacher', [DashBoardController::class, 'orgTeacherProfile'])->name('profiles.org-teacher');

    //edit org teacher profile
    Route::get('/profiles/org-teacher/edit', [DashBoardController::class, 'editOrgTeacherProfile'])->name('edit-profiles.org-teacher');

    //update org teacher profile
    Route::post('/profiles/org-teacher/update', [DashBoardController::class, 'teacherUpdateProfile'])->name('update-profiles.org-teacher');

    //reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::post('/reports/excel', [ReportController::class, 'reportExport'])->name('reports.export');
    Route::post('/reports/game-score', [ReportController::class, 'gameExport'])->name('game.export');
    Route::post('/reports/storybook-score', [ReportController::class, 'storybookExport'])->name('storybook.export');
});

Route::group(['middleware' => ['auth','isSuperAdminnBcStaff']], function () {

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
