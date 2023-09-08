<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationController;
use Src\BlendedConcept\Organization\Presentation\HTTP\OrganizationTeacherStudentController;
use Src\BlendedConcept\Organization\Presentation\HTTP\PlanController;
use Src\BlendedConcept\Organization\Presentation\HTTP\SubscribtionInvoiceController;

Route::group(['middleware' => ['auth']], function () {


    Route::resource('organizations', OrganizationController::class);


    Route::get('/org_view_teacher_student', [OrganizationTeacherStudentController::class, 'index'])->name('org_view_teacher_student.index');
    Route::get('/org_view_teacher_student/teacher/show', [OrganizationTeacherStudentController::class, 'showTeacher'])->name('org_view_teacher_student.teacher.show');
    Route::get('/org_view_teacher_student/teacher/edit', [OrganizationTeacherStudentController::class, 'editTeacher'])->name('org_view_teacher_student.teacher.edit');
    Route::get('/org_view_teacher_student/teacher/create', [OrganizationTeacherStudentController::class, 'createTeacher'])->name('org_view_teacher_student.teacher.create');

    Route::get('/org_view_teacher_student/student/show', [OrganizationTeacherStudentController::class, 'showStudent'])->name('org_view_teacher_student.student.show');
    Route::get('/org_view_teacher_student/student/edit', [OrganizationTeacherStudentController::class, 'editStudent'])->name('org_view_teacher_student.student.edit');
    Route::get('/org_view_teacher_student/student/create', [OrganizationTeacherStudentController::class, 'createStudent'])->name('org_view_teacher_student.student.create');
});
