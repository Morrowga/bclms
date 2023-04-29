<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Src\BlendedConcept\Organization\Presentation\HTTP\DashboardBoardController;
use Src\BlendedConcept\User\Presentation\HTTP\NotificationController;
use Src\BlendedConcept\User\Presentation\HTTP\PermissionController;
use Src\BlendedConcept\User\Presentation\HTTP\PortalController;
use Src\BlendedConcept\User\Presentation\HTTP\RoleController;
use Src\BlendedConcept\User\Presentation\HTTP\SettingController;
use Src\BlendedConcept\User\Presentation\HTTP\StudentController;
use Src\BlendedConcept\User\Presentation\HTTP\TeacherController;
use Src\BlendedConcept\User\Presentation\HTTP\UserController;
use Src\BlendedConcept\User\Presentation\HTTP\AnnouncementController;
use Src\BlendedConcept\Organization\Presentation\HTTP\LibraryController;
Route::group(['middleware' => ['auth']], function () {
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::post('changepassword', [UserController::class,'changePassword'])->name('changepassword');


    //announcement
    Route::resource('announcements', AnnouncementController::class);

    Route::get('settings', [SettingController::class, 'index']);

    //mark as read with id
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name("markAsRead");

    //mark as read all
    Route::post('/notifications/readall', [NotificationController::class, 'readAll'])->name("markAsReadAll");

    //get all notifications
    Route::get('/notifications/index', [NotificationController::class, "getAllNotifications"])->name("notifications");


    // student add
    Route::get("addstudent", [StudentController::class, 'create'])->name('students.store');
    Route::get('editstudent/{student}', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('updatestudent/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::get("studentdashboard", [StudentController::class, 'dashboard'])->name('studentdashboard');
    Route::post("students", [StudentController::class, 'store'])->name('students.store');

    // announcement
    Route::resource("announcements", AnnouncementController::class);


    // teacher
    Route::get("teacherdashboard", [TeacherController::class, 'dashboard'])->name('teacherdashboard');



     // library
     Route::get("libraries", [LibraryController::class, 'index'])->name('libraries');

    Route::get("userprofile", [DashboardBoardController::class, 'userProfile'])->name('userprofile');





});
Route::get('/', [PortalController::class, 'index'])->name('portal');
Route::get("testing/route", function () {
    return Inertia::render('Index');
});
