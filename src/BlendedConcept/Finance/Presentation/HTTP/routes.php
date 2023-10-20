<?php

use Illuminate\Support\Facades\Route;
use Src\BlendedConcept\Finance\Presentation\HTTP\PlanController;
use Src\BlendedConcept\Finance\Presentation\HTTP\SubscribtionInvoiceController;

Route::group(['middleware' => ['auth']], function () {
    Route::resource('plans', PlanController::class);
    // Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    // Route::get('/plans/edit', [PlanController::class, 'edit'])->name('plans.edit');
    // Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    // Route::get('/plans/show', [PlanController::class, 'show'])->name('plans.show');
    Route::get('/plans/orgcreate', [PlanController::class, 'planfororg'])->name('planfororg.show');
    Route::put('/plans/{plan}/change_status', [PlanController::class, 'changeStatus'])->name('plans.change_status');

    Route::get('subscribptioninvoice', [SubscribtionInvoiceController::class, 'index'])->name('subscription_invoice');
    Route::put('subscribptioninvoice/{subscription}/update/b2b', [SubscribtionInvoiceController::class, 'updateB2b'])->name('subscription_invoice.updateb2b');
    Route::put('subscribptioninvoice/{subscription}/update/b2c', [SubscribtionInvoiceController::class, 'updateB2c'])->name('subscription_invoice.updateb2c');

    Route::get('subscriptions/add_subscription', [SubscribtionInvoiceController::class, 'addOrgSubscription'])->name('subscriptions.add_subscription');

    Route::put('subscriptions/store_subscription', [SubscribtionInvoiceController::class, 'storeOrgSubscription'])->name('subscriptions.store_subscription');
});
