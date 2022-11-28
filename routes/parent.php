<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\guardian\GuardianApplicationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\guardian\GuardianChildrenController;
use App\Http\Controllers\guardian\GuardianWithdrawalApplicationController;
use App\Http\Controllers\guardian\ParentJsonController;
/*
|--------------------------------------------------------------------------
| Parent Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth']], function () {

    Route::prefix('parent')->name('parent.')->group(function () {
        Route::get('showChildrens', [GuardianChildrenController::class, "showChildrens"])->name("showChildrens");
        Route::get('childrenDetails', [GuardianChildrenController::class, "getChildrenDetails"])->name("childrenDetails");
        Route::get('contractTransaction', [GuardianChildrenController::class, "getContractTransaction"])->name("contractTransaction");
        Route::post('transactionPaymentAttempt', [GuardianChildrenController::class, "showTransactionPaymentAttempt"])->name("transactionPaymentAttempt");
    });


    Route::prefix('parent')->name('parent.')->group(function () {
        Route::resource('applications', GuardianApplicationController::class);
        Route::resource('withdrawals', GuardianWithdrawalApplicationController::class);

    });
    Route::prefix('parent')->name('parent.')->group(function () {
    Route::post('student/{student_id}/transaction/{transaction_id}', [TransactionController::class, 'update_transactions']);
    Route::post('json/{methodName}', [ParentJsonController::class, 'index']);
    });

});

