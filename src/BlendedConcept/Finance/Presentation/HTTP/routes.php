<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Finance\Presentation\HTTP\PlanController;
use Src\BlendedConcept\Finance\Presentation\HTTP\SubscribtionInvoiceController;

Route::group(['middleware' => ['auth']], function () {
    // Route::resource('plans', PlanController::class);
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::get('/plans/show', [PlanController::class, 'show'])->name('plans.show');
    Route::get('/plans/orgcreate', [PlanController::class, 'planfororg'])->name('planfororg.show');

    Route::get('subscribptioninvoice', [SubscribtionInvoiceController::class, 'index'])->name('subscription_invoice');
});
