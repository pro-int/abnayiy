<?php

use App\Http\Controllers\admin\AdminNoorQueueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentPermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferRequestController;
use App\Http\Controllers\WalletController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// old_data api
//will be deleted
// /gdasfdnkksjfksjadbaskdjbfdksjbfksadjbfs/" & id & "/hash?
// Route::get('gdasfdnkksjfksjadbaskdjbfdksjbfksadjbfs/{id}/hash/{password}', [LevelController::class, 'changepassword']);

// public login
Route::post('user/auth/login', [AuthController::class, 'login']);
Route::post('user/auth/changepassword', [AuthController::class, 'changepassword']);

Route::post('user/auth/register', [AuthController::class, 'Register']);
Route::post('user/auth/forgetPassword', [AuthController::class, 'SendPasswordRestLink']);
Route::post('user/auth/resetPassword', [AuthController::class, 'resetPasswordRestLink']);
Route::post('user/auth/reset-password-send-code', [AuthController::class, 'sendPasswordResetCode']);

//guest  sms vrifcation
Route::post('user/mobile/verify_code', [MobileController::class, 'verify']);
Route::get('user/mobile/send_code', [MobileController::class, 'sendCode']);


//get user plans inforamtion
Route::middleware(['auth:sanctum'])->prefix('user')->group(function () {
    // user Auth
    Route::get('auth/user', [AuthController::class, 'user']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/update', [AuthController::class, 'update']);
    Route::post('auth/changepassword', [AuthController::class, 'changepassword']);

    // wallet
    Route::post('wallet', [WalletController::class, 'getUserWallet']);
    Route::post('wallet/{wallet}/transactions', [WalletController::class, 'geWalletTransactions']);

    // applications
    Route::post('applications/new_application', [ApplicationController::class, 'store']);
    Route::post('applications/edit_application', [ApplicationController::class, 'update']);
    Route::get('application/{id}', [ApplicationController::class, 'application_info']);
    Route::match(['get', 'post'], 'application/{application_id}/selectPlan', [ApplicationController::class, 'selectPlan']);


    //permissions
    Route::get('student/view_permissions', [StudentPermissionController::class, 'get_permissions']);
    Route::post('student/{student_id}/request_permission', [StudentPermissionController::class, 'new_permission']);

    // students
    Route::get('student/{id}', [StudentController::class, 'student_info']);

    // contracts
    Route::get('contracts', [ContractController::class, 'contracts']);
    Route::get('contracts/{contract}', [ContractController::class, 'getContract']);


    // student
    Route::get('student/{student_id}/attandance_report', [StudentAttendanceController::class, 'get_attandance']);
    Route::get('student/{student_id}/participation', [StudentController::class, 'student_participation']);
    Route::post('student/{student_id}/student_call', [StudentController::class, 'student_call']);
    Route::get('student/{student_id}/transactions', [TransactionController::class, 'transactions']);
    Route::post('student/{student_id}/transaction/{transaction_id}', [TransactionController::class, 'update_transactions']);
    Route::post('student/{student_id}/transaction/{transaction_id}/getTransactionInfo', [TransactionController::class, 'getTransactionInfo']);

    // reports
    Route::post('student/reports/{report}', [ReportController::class, 'report_index']);

    //meetings
    Route::get('meeting/used_slots', [MeetingController::class, 'used_slots']);
    Route::post('meeting/new_meeting', [MeetingController::class, 'new_meeting']);

    // send code
    // Route::post('auth/verify_code', [MobileController::class, 'verify']);
    // Route::get('auth/send_code', [MobileController::class, 'sendCode']);

    Route::apiResource('student/{contract}/transfers', TransferRequestController::class)->except(['destroy']);
});
Route::post('student/{contract}/transfers/{transfer}/transaction_response', [TransferRequestController::class, 'transaction_response'])->name('transaction_response');
Route::post('user/student/transaction/{transaction_id}/response', [TransactionController::class, 'payfort_processResponse'])->name('payfort_processResponse');



//profile
// Route::post('user/updateProfile', [UserProfileController::class, 'updateProfile']);
// Route::get('user/applications/application_data', [ApplicationController::class, 'input_data']);
Route::get('user/data', [Controller::class, 'data']);
Route::get('user/nationalities/{id}', [NationalityController::class, 'index']);
Route::get('user/countries/{id}', [CountryController::class, 'index']);


Route::prefix('noor')->group(function () {
    Route::post('getnewjob', [AdminNoorQueueController::class, 'getNewJob']);
    Route::post('update_job', [AdminNoorQueueController::class, 'update_job']);
    Route::post('change_job_stu', [AdminNoorQueueController::class, 'change_job_stu']);
});
