<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationController;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationTeacherStudentController;
use Src\BlendedConcept\Organization\Presentation\HTTP\PlanController;
use Src\BlendedConcept\Organization\Presentation\HTTP\SubscribtionInvoiceController;

Route::group(['middleware' => ['auth']], function () {

    Route::resource('organizations', OrganizationController::class);
    Route::get('/organizations/edit', [OrganizationController::class, 'testEdit'])->name('organizations.test.edit');

    // Route::resource('plans', PlanController::class);

    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::get('/plans/show', [PlanController::class, 'show'])->name('plans.show');
    Route::get('/plans/orgcreate', [PlanController::class, 'planfororg'])->name('planfororg.show');

    Route::get('subscribptioninvoice', [SubscribtionInvoiceController::class, 'index']);

    // Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
    // Route::get('/organizations/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
    // Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    // Route::get('/organizations/show', [OrganizationController::class, 'show'])->name('organizations.show');

    Route::get('/org_view_teacher_student', [OrganizationTeacherStudentController::class, 'index'])->name('org_view_teacher_student.index');
    Route::get('/org_view_teacher_student/teacher/show', [OrganizationTeacherStudentController::class, 'showTeacher'])->name('org_view_teacher_student.teacher.show');
    Route::get('/org_view_teacher_student/teacher/edit', [OrganizationTeacherStudentController::class, 'editTeacher'])->name('org_view_teacher_student.teacher.edit');
    Route::get('/org_view_teacher_student/teacher/create', [OrganizationTeacherStudentController::class, 'createTeacher'])->name('org_view_teacher_student.teacher.create');

    Route::get('/org_view_teacher_student/student/show', [OrganizationTeacherStudentController::class, 'showStudent'])->name('org_view_teacher_student.student.show');
    Route::get('/org_view_teacher_student/student/edit', [OrganizationTeacherStudentController::class, 'editStudent'])->name('org_view_teacher_student.student.edit');
    Route::get('/org_view_teacher_student/student/create', [OrganizationTeacherStudentController::class, 'createStudent'])->name('org_view_teacher_student.student.create');
});
