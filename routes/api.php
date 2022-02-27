<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthCustomerController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\SubCategoryController;
use \App\Http\Controllers\TransactionController;
use \App\Http\Controllers\PaymentController;
use \App\Http\Controllers\ReportController;

Route::post('auth/login', [AuthCustomerController::class, 'login'])->name('auth.login');

Route::group([
    'middleware' => 'auth:sanctum'
], function(){
    // Categories
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('sub-category', SubCategoryController::class);

    // Transaction
    Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('transaction/{transaction}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::post('transaction', [TransactionController::class, 'store'])->name('transaction.store');

    // Payment
    Route::post('payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('transaction/{transaction_id}/payments', [PaymentController::class, 'index'])->name('payment.index');

    // Report ()
    Route::get('report/transaction-payments', [ReportController::class, 'transaction_payments'])->name('report.transaction_payments');

    // Logout user
    Route::post('auth/logout', [AuthCustomerController::class, 'logout'])->name('auth.logout');
});
